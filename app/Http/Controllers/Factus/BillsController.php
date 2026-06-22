<?php

namespace App\Http\Controllers\Factus;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factus\Concerns\InteractsWithFactus;
use Illuminate\Http\Request;

class BillsController extends Controller
{
    use InteractsWithFactus;

    public function index(Request $request)
    {
        $query = array_filter([
            'filter[identification]' => $request->identification,
            'filter[names]' => $request->names,
            'filter[number]' => $request->number,
            'filter[prefix]' => $request->prefix,
            'filter[reference_code]' => $request->reference_code,
            'filter[status]' => $request->status,
        ], fn ($value) => $value !== null && $value !== '');

        $response = $this->factusRequest()->get($this->factusUrl('/v2/bills'), $query);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json([
            'error' => 'No se obtuvieron las facturas',
            'status' => $response->status(),
            'message' => $response->body(),
        ], $response->status());
    }

    public function validateBill(Request $request)
    {
        $numberingData = $this->numberingRangesData();

        if (!isset($numberingData['data']['data'])) {
            return response()->json(['error' => 'No hay datos de numeracion'], 422);
        }

        $range = collect($numberingData['data']['data'])->firstWhere('document', 'Factura de Venta');

        if (!$range) {
            return response()->json(['error' => 'No se encontro el rango de la factura'], 422);
        }

        $input = array_merge($request->all(), $request->json()->all());

        if (empty($input)) {
            $input = $this->demoBillPayload();
        }

        $data = validator($input, [
            'reference_code' => ['nullable', 'string'],
            'document' => ['nullable', 'string'],
            'operation_type' => ['nullable', 'string'],
            'observation' => ['nullable', 'string'],
            'payment_details' => ['required', 'array', 'min:1'],
            'payment_details.*.payment_form' => ['required', 'string'],
            'payment_details.*.payment_method_code' => ['required', 'string'],
            'payment_details.*.reference_code' => ['nullable', 'string'],
            'payment_details.*.amount' => ['required', 'numeric'],
            'establishment' => ['required', 'array'],
            'establishment.name' => ['required', 'string'],
            'establishment.address' => ['required', 'string'],
            'establishment.municipality_code' => ['required', 'string'],
            'establishment.phone_number' => ['nullable', 'string'],
            'establishment.email' => ['nullable', 'email'],
            'customer' => ['required', 'array'],
            'customer.identification_document_code' => ['required', 'string'],
            'customer.identification' => ['required', 'string'],
            'customer.legal_organization_code' => ['required', 'string'],
            'customer.tribute_code' => ['required', 'string'],
            'customer.names' => ['required', 'string'],
            'customer.company' => ['nullable', 'string'],
            'customer.address' => ['required', 'string'],
            'customer.email' => ['required', 'email'],
            'customer.phone' => ['required', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.code_reference' => ['required', 'string'],
            'items.*.name' => ['required', 'string'],
            'items.*.quantity' => ['required', 'numeric'],
            'items.*.discount_rate' => ['required', 'numeric'],
            'items.*.price' => ['required', 'numeric'],
            'items.*.unit_measure_code' => ['required', 'string'],
            'items.*.standard_code' => ['required', 'string'],
            'items.*.taxes' => ['required', 'array', 'min:1'],
            'items.*.taxes.*.code' => ['required', 'string'],
            'items.*.taxes.*.rate' => ['required', 'numeric'],
        ])->validate();

        $payload = [
            'numbering_range_id' => $range['id'],
            'reference_code' => $data['reference_code'] ?? 'FAC'.time(),
            'document' => $data['document'] ?? '01',
            'operation_type' => $data['operation_type'] ?? '10',
            'observation' => $data['observation'] ?? 'Factura generada desde ApiFactus',
            'payment_details' => $data['payment_details'],
            'establishment' => $data['establishment'],
            'customer' => $data['customer'],
            'items' => $data['items'],
        ];

        $response = $this->factusRequest()->post($this->factusUrl('/v2/bills/validate'), $payload);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        $error = $response->json();

        return response()->json([
            'status_http' => $response->status(),
            'factus_response' => $error,
            'errors' => $error['data']['errors'] ?? null,
            'message' => $error['message'] ?? null,
        ], $response->status());
    }

    private function demoBillPayload(): array
    {
        return [
            'reference_code' => 'FAC'.time(),
            'document' => '01',
            'operation_type' => '10',
            'observation' => 'Factura generada desde ApiFactus',
            'payment_details' => [
                [
                    'payment_form' => '1',
                    'payment_method_code' => '10',
                    'reference_code' => 'PAGO-001',
                    'amount' => 11900,
                ],
            ],
            'establishment' => [
                'name' => 'MI EMPRESA SAS',
                'address' => 'Calle 1 # 1-1',
                'municipality_code' => '11001',
                'phone_number' => '3000000000',
                'email' => 'facturacion@miempresa.com',
            ],
            'customer' => [
                'identification_document_code' => '31',
                'identification' => '123456789',
                'legal_organization_code' => '1',
                'tribute_code' => 'ZZ',
                'names' => 'Cliente Ejemplo',
                'company' => 'Cliente Ejemplo SAS',
                'address' => 'Calle Cliente 123',
                'email' => 'cliente@ejemplo.com',
                'phone' => '3001112233',
            ],
            'items' => [
                [
                    'code_reference' => 'PROD-001',
                    'name' => 'Producto de prueba',
                    'quantity' => 1,
                    'discount_rate' => 0,
                    'price' => 10000,
                    'unit_measure_code' => '94',
                    'standard_code' => '999',
                    'taxes' => [
                        [
                            'code' => '01',
                            'rate' => 19.0,
                        ],
                    ],
                ],
            ],
        ];
    }

    private function numberingRangesData(): ?array
    {
        $cached = $this->cached('datanumeracion');

        if (isset($cached['data']['data'])) {
            return $cached;
        }

        $response = $this->factusRequest()->get($this->factusUrl('/v2/numbering-ranges'));

        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();
        cache()->put('datanumeracion', $data, 3600);

        return $data;
    }
}

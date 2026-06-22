<?php

namespace App\Http\Controllers\Factus;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factus\Concerns\InteractsWithFactus;
use Illuminate\Http\Request;

class FactusResourcesController extends Controller
{
    use InteractsWithFactus;

    public function company()
    {
        return $this->proxyGet('/v2/companies');
    }

    public function bill(Request $request, string $number)
    {
        return $this->proxyGet("/v2/bills/{$number}");
    }

    public function billPdf(string $number)
    {
        return $this->proxyGet("/v2/bills/{$number}/download-pdf");
    }

    public function billXml(string $number)
    {
        return $this->proxyGet("/v2/bills/{$number}/download-xml");
    }

    public function billAttachedDocument(string $number)
    {
        return $this->proxyGet("/v2/bills/{$number}/download-xml-attached-document");
    }

    public function billEvents(string $number)
    {
        return $this->proxyGet("/v2/bills/{$number}/radian/events");
    }

    public function sendBillEmail(Request $request, string $number)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        return $this->proxyPost("/v2/bills/{$number}/send-email", [
            'email' => $request->email,
        ]);
    }

    public function creditNotes(Request $request)
    {
        return $this->proxyGet('/v2/credit-notes', $this->documentFilters($request));
    }

    public function supportDocuments(Request $request)
    {
        return $this->proxyGet('/v2/support-documents', $this->documentFilters($request));
    }

    private function documentFilters(Request $request): array
    {
        return array_filter([
            'filter[identification]' => $request->identification,
            'filter[names]' => $request->names,
            'filter[number]' => $request->number,
            'filter[prefix]' => $request->prefix,
            'filter[reference_code]' => $request->reference_code,
            'filter[status]' => $request->status,
            'filter[per_page]' => $request->per_page,
            'filter[created_at][start_date]' => $request->start_date,
            'filter[created_at][end_date]' => $request->end_date,
            'page' => $request->page,
        ], fn ($value) => $value !== null && $value !== '');
    }

    private function proxyGet(string $path, array $query = [])
    {
        $response = $this->factusRequest()->get($this->factusUrl($path), $query);

        return $this->jsonResponse($response, 'No se pudo consultar el recurso');
    }

    private function proxyPost(string $path, array $payload)
    {
        $response = $this->factusRequest()->post($this->factusUrl($path), $payload);

        return $this->jsonResponse($response, 'No se pudo procesar la solicitud');
    }

    private function jsonResponse($response, string $message)
    {
        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json([
            'error' => $message,
            'status' => $response->status(),
            'message' => $response->body(),
        ], $response->status());
    }
}

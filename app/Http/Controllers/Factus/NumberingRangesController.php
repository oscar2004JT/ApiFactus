<?php

namespace App\Http\Controllers\Factus;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factus\Concerns\InteractsWithFactus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NumberingRangesController extends Controller
{
    use InteractsWithFactus;

    public function index(Request $request)
    {
        $query = array_filter([
            'filter[id]' => $request->id,
            'filter[document]' => $request->document,
            'filter[resolution_number]' => $request->resolution_number,
            'filter[technical_key]' => $request->technical_key,
            'filter[is_active]' => $request->is_active,
        ], fn ($value) => $value !== null && $value !== '');

        $response = $this->factusRequest()->get($this->factusUrl('/v2/numbering-ranges'), $query);

        if ($response->successful()) {
            Cache::put('datanumeracion', $response->json(), 3600);

            return response()->json($response->json());
        }

        return response()->json([
            'error' => 'No se pudieron obtener los rangos',
            'status' => $response->status(),
            'message' => $response->body(),
        ], $response->status());
    }
}

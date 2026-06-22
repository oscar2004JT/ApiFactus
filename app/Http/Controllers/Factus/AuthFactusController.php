<?php

namespace App\Http\Controllers\Factus;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factus\Concerns\InteractsWithFactus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AuthFactusController extends Controller
{
    use InteractsWithFactus;

    public function token()
    {
        $response = Http::asForm()->post($this->factusUrl('/oauth/token'), [
            'grant_type' => config('services.factus.grant_type', 'password'),
            'client_id' => config('services.factus.client_id'),
            'client_secret' => config('services.factus.client_secret'),
            'username' => config('services.factus.username'),
            'password' => config('services.factus.password'),
        ]);

        if ($response->successful()) {
            $data = $response->json();

            Cache::put('accessToken', $data['access_token'], 3600);
            Cache::put('refreshToken', $data['refresh_token'] ?? null, 3600);

            return response()->json([
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'] ?? null,
            ]);
        }

        return response()->json([
            'error' => 'No se pudo obtener el token',
            'message' => $response->body(),
            'status' => $response->status(),
        ], 400);
    }
}

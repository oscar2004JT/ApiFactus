<?php

namespace App\Http\Controllers\Factus\Concerns;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

trait InteractsWithFactus
{
    protected function factusUrl(string $path): string
    {
        return rtrim(config('services.factus.url', 'https://api-sandbox.factus.com.co'), '/').'/'.ltrim($path, '/');
    }

    protected function factusRequest(): PendingRequest
    {
        return Http::acceptJson()->asJson()->withToken((string) Cache::get('accessToken'));
    }

    protected function cached(string $key)
    {
        return Cache::get($key);
    }
}

<?php

namespace App\Http\Controllers\Factus;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factus\Concerns\InteractsWithFactus;
class CatalogsController extends Controller
{
    use InteractsWithFactus;

    public function municipalities()
    {
        return $this->referenceTable('municipios', 'https://developers.factus.com.co/tablas-de-referencia/municipios/');
    }

    public function productTributes()
    {
        return $this->referenceTable('tributos de productos', 'https://developers.factus.com.co/tablas-de-referencia/tablas/');
    }

    public function measurementUnits()
    {
        return $this->referenceTable('unidades de medida', 'https://developers.factus.com.co/tablas-de-referencia/unit-measures/');
    }

    private function referenceTable(string $name, string $url)
    {
        return response()->json([
            'message' => "En Factus API V2, {$name} se consulta como tabla de referencia y no como endpoint REST.",
            'documentation_url' => $url,
        ]);
    }
}

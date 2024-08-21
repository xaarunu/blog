<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Incapacidad;
use App\Models\MiSalud;
use App\Models\PersonalSintomas;
use App\Models\usuario_enfermedad;
use DateTime;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function rating()
    {
        $tematica = "incapacidades";
        $ultimoRegistro = Incapacidad::latest('created_at')->selectRaw('MONTH(created_at) as mes, YEAR(created_at) as año')->first();
        $fechaInicioPeriodo = date('Y-m-d', strtotime("$ultimoRegistro?->año-$ultimoRegistro?->mes-01"));
        $fechaFinPeriodo = date('Y-m-t', strtotime("$ultimoRegistro?->año-$ultimoRegistro?->mes-01"));
        // Filtrar los registros de Incapacidad según el mes y año del último registro
        $incapacidades = Incapacidad::whereMonth('created_at', $ultimoRegistro?->mes)
            ->whereYear('created_at', $ultimoRegistro?->año)
            ->orderBy('created_at')
            ->with(['user' => function ($query) {
                $query->with('getArea');
            }])
            ->get();
        $zonas = $incapacidades->groupBy(function ($item) {
            return $item->user->getArea->area_nombre ?? null;
        })->map(function ($grupo, $area) {
            return [
                'id' => $grupo->first()->user->getArea->id ?? null,
                'area' => $area,
                'cantidad_registros' => $grupo->count(),
            ];
        });
        // Obtener todas las áreas con division_id igual a "DX"
        $todasLasAreas = Area::where('division_id', 'DX')->where('area_clave', '!=', 'DXSU')->pluck('area_nombre');
        // Obtener todas las zonas (incluso las que no tienen incapacidades) con valor cero
        $todasLasZonas = $todasLasAreas->map(function ($area) use ($zonas) {
            $zonaExistente = $zonas->where('area', $area)->first();
            return [
                'id' => $zonaExistente['id'] ?? null,
                'area' => $area,
                'cantidad_registros' => $zonaExistente['cantidad_registros'] ?? 0,
            ];
        });
        // Calcular el promedio de cantidad_registros
        $promedio = $todasLasZonas->avg('cantidad_registros');
        // Asignar colores y actualizar el array $todasLasZonas
        $todasLasZonas = $todasLasZonas->map(function ($zona) use ($promedio) {
            $color = 'verde'; // Por defecto, verde si es menor al promedio

            if ($zona['cantidad_registros'] > $promedio) {
                $color = 'rojo';
            } elseif ($zona['cantidad_registros'] === $promedio) {
                $color = 'amarillo';
            }

            $zona['color'] = $color;
            return $zona;
        });
        // Ordenar todas las zonas según la cantidad de registros en orden descendente
        $todasLasZonas = $todasLasZonas->sortBy('cantidad_registros')->values();
        $first = $todasLasZonas->take(3);
        // $mesTexto = DateTime::createFromFormat('!m', $ultimoRegistro->mes)->format('F');
        // info($mesTexto);
        return view('incapacidades.ranking-incapacidades', [
            'zonas' => $todasLasZonas,
            'first' => $first,
            'fechaInicioPeriodo' => $fechaInicioPeriodo,
            'fechaFinPeriodo' => $fechaFinPeriodo,
            'tematica' => $tematica,
        ]);
    }

    private function obtenerDatosComunes(Request $request, $modelo, $campoFecha, $tematica)
    {
        $fecha_inicio = date($request->input('fecha_inicio'));
        $fecha_fin = date($request->input('fecha_fin'));
        $registros = $modelo::whereBetween($campoFecha, [$fecha_inicio, $fecha_fin])
            ->orderBy($campoFecha)
            ->with(['user' => function ($query) {
                $query->with('getArea');
            }])
            ->get();

        $zonas = $registros->groupBy(function ($item) {
            return $item->user->getArea->area_nombre ?? null;
        })->map(function ($grupo, $area) {
            return [
                'id' => $grupo->first()->user->getArea->id ?? null,
                'area' => $area,
                'cantidad_registros' => $grupo->count(),
            ];
        });

        $todasLasAreas = Area::where('division_id', 'DX')->where('area_clave', '!=', 'DXSU')->pluck('area_nombre');

        $todasLasZonas = $todasLasAreas->map(function ($area) use ($zonas) {
            $zonaExistente = $zonas->where('area', $area)->first();
            return [
                'id' => $zonaExistente['id'] ?? null,
                'area' => $area,
                'cantidad_registros' => $zonaExistente['cantidad_registros'] ?? 0,
            ];
        });

        $promedio = $todasLasZonas->avg('cantidad_registros');

        $todasLasZonas = $todasLasZonas->map(function ($zona) use ($promedio) {
            $color = 'verde';

            if ($zona['cantidad_registros'] > $promedio) {
                $color = 'rojo';
            } elseif ($zona['cantidad_registros'] === $promedio) {
                $color = 'amarillo';
            }

            $zona['color'] = $color;
            return $zona;
        });

        $todasLasZonas = $todasLasZonas->sortBy('cantidad_registros')->values();
        $first = $todasLasZonas->take(3);
        // $mesTexto = "";
        // Obtenemos las fechas de inicio y fin del período
        $fechaInicioPeriodo = $fecha_inicio ? $fecha_inicio : "";
        $fechaFinPeriodo = $fecha_fin ? $fecha_fin : "";

        return view('incapacidades.ranking-incapacidades', [
            'zonas' => $todasLasZonas,
            'first' => $first,
            // 'month' => $mesTexto,
            'tematica' => $tematica,
            'fechaInicioPeriodo' => $fechaInicioPeriodo,
            'fechaFinPeriodo' => $fechaFinPeriodo,
        ]);
    }

    public function incapacidades(Request $request)
    {
        $tematica = "incapacidades";
        return $this->obtenerDatosComunes($request, Incapacidad::class, 'created_at', $tematica);
    }

    public function notasMeddicas(Request $request)
    {
        $tematica = "notas medicas";
        return $this->obtenerDatosComunes($request, MiSalud::class, 'fecha', $tematica);
    }

    public function Enfermos(Request $request)
    {
        $tematica = "enfermos en Rij";
        return $this->obtenerDatosComunes($request, PersonalSintomas::class, 'fecha_deteccion', $tematica);
    }

    public function rankingFiltro(Request $request)
    {
        $tematica = $request->input('tematica');
        if ($tematica == 'incapacidades') {
            return $this->incapacidades($request);
        } elseif ($tematica == 'notasMedicas') {
            return $this->notasMeddicas($request);
        } else {
            return $this->Enfermos($request);
        }
    }
}

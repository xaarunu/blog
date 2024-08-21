<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use App\Models\MiSalud;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MiSaludTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function testCrearMiSalud()
    {   
        $miSalud = MiSalud::factory()->create([
            'rpe' => 12345,
            'fecha_nacimiento' => '1990-01-01',
            'sexo' => 'M',
            'fecha' => '2022-01-01',
            'hora' => '10:00:00',
            'altura' => 1.75,
            'peso' => 70,
            'imc' => 22.86,
            'cintura' => 80,
            'cadera' => 100,
            'presionSis' => 120,
            'presionDia' => 80,
            'temperatura' => 36.5,
            'saturacion' => 95,
            'glucosa' => 100,
            'cardiaca' => 80,
            'respiratoria' => 16,
            'alergias' => 'Ninguna',
            'tipo' => 'Consulta',
            'observaciones' => 'Ninguna',
            'diagnostico' => 'Ninguno',
            'tratamiento' => 'Ninguno',
        ]);
        $this->assertDatabaseHas('mi_saluds', [
            'rpe' => 12345,
            'fecha_nacimiento' => '1990-01-01',
            'sexo' => 'M',
            'fecha' => '2022-01-01',
            'hora' => '10:00:00',
            'altura' => 1.75,
            'peso' => 70,
            'imc' => 22.86,
            'cintura' => 80,
            'cadera' => 100,
            'presionSis' => 120,
            'presionDia' => 80,
            'temperatura' => 36.5,
            'saturacion' => 95,
            'glucosa' => 100,
            'cardiaca' => 80,
            'respiratoria' => 16,
            'alergias' => 'Ninguna',
            'tipo' => 'Consulta',
            'observaciones' => 'Ninguna',
            'diagnostico' => 'Ninguno',
            'tratamiento' => 'Ninguno',
        ]);
        $response = $this->get('/');
        $response->assertStatus(302);
    }
}

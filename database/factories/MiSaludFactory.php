<?php

namespace Database\Factories;
use App\Models\MiSalud;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;


class MiSaludFactory extends Factory
{
    protected $model = MiSalud::class;
    
    // @return array
    
    public function definition()
    {
        $fechaInicio = Carbon::create(2022, 1, 1);
        $fechaFin = Carbon::create(2023, 12, 31);
        $fechaAleatoria = Carbon::createFromFormat('Y-m-d H:i:s', $this->faker->dateTimeBetween($fechaInicio, $fechaFin)->format('Y-m-d H:i:s'));

        
        return [
            'rpe' => $this->faker->numberBetween(10000, 99999),
            'fecha_nacimiento' => $this->faker->date(),
            'sexo' => $this->faker->randomElement(['M', 'F']),
            // 'fecha' => $this->faker->date(),
            'fecha' => $fechaAleatoria,
            'hora' => $this->faker->time(),
            'altura' => $this->faker->randomFloat(2, 1, 2.5),
            'peso' => $this->faker->randomFloat(2, 40, 150),
            'imc' => $this->faker->randomFloat(2, 15, 40),
            'cintura' => $this->faker->randomFloat(2, 50, 150),
            'cadera' => $this->faker->randomFloat(2, 50, 150),
            'presionSis' => $this->faker->numberBetween(80, 200),
            'presionDia' => $this->faker->numberBetween(50, 120),
            'temperatura' => $this->faker->randomFloat(2, 35, 40),
            'saturacion' => $this->faker->numberBetween(80, 100),
            'glucosa' => $this->faker->numberBetween(50, 200),
            'cardiaca' => $this->faker->numberBetween(50, 150),
            'respiratoria' => $this->faker->numberBetween(10, 30),
            'alergias' => $this->faker->sentence(),
            'tipo' => $this->faker->randomElement(['Consulta', 'Examen', 'Vacuna']),
            'observaciones' => $this->faker->sentence(),
            'diagnostico' => $this->faker->sentence(),
            'tratamiento' => $this->faker->sentence(),
        ];
    }
}

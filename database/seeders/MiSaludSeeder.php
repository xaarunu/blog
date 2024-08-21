<?php

namespace Database\Seeders;
use App\Models\MiSalud;

use Illuminate\Database\Seeder;

class MiSaludSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MiSalud::factory()->count(50)->create();
    }
}

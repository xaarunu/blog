<?php

namespace Database\Seeders;

use App\Models\UserStatus;
use Illuminate\Database\Seeder;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserStatus::create(['name' => 'Pendiente']);
        UserStatus::create(['name' => 'Autorizado']);
        UserStatus::create(['name' => 'Modificacion Pendiente']);
        UserStatus::create(['name' => 'Baja']);
    }
}

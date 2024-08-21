<?php

namespace App\Providers;

use App\Observers\GeneralObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $modelos = [
            // \App\Models\Audiometria::class,
            \App\Models\Datosuser::class,
            \App\Models\EntregaRecepcion::class,
            // \App\Models\Incapacidad::class,
            // \App\Models\MiSalud::class,
            \App\Models\Personales::class,
            // \App\Models\PrestacionLentes::class,
            // \App\Models\ProSalud::class,
            \Spatie\Permission\Models\Role::class,
            \App\Models\Soporte::class,
            // \App\Models\UnidadesMedicas::class,
            \App\Models\User::class,
            \App\Models\UsuarioPendiente::class,
            // \App\Models\UsuarioUnidad::class,
        ];

        foreach($modelos as $modelo) {
            $modelo::observe(GeneralObserver::class);
        }
    }
}

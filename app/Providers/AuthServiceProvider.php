<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\Fortify;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Fortify::authenticateUsing(function (Request $request) {

            if ($request->rpe ==  'admin' or 'usuario1') {

                Auth::attempt([
                    'email'    => $request->rpe . '@cfe.mx',
                    'password' => $request->password
                ]);
            }
            $ldap_enabled = env('ENABLE_LDAP');
            if ($ldap_enabled) {
                $ldap_connect = ldap_connect(env('LDAP_HOST'));

                ldap_set_option($ldap_connect, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ldap_connect, LDAP_OPT_REFERRALS, 0);

                $ldap_bind = @ldap_bind($ldap_connect, $request->rpe . '@cfe.mx', $request->password);

                if ($ldap_bind) {
                    $user = User::firstWhere('rpe', $request->rpe);
                    if (is_null($user)) {

                        $user = User::create([
                            'rpe'       => $request->rpe,
                            //'nombre'    => $nombre,
                            'password'  => bcrypt($request->password)
                        ]);
                        $user->assignRole('usuario');
                    }

                    return $user;
                } else {

                    return null;
                }
            }
            if (Auth::attempt([
                'rpe' => $request->rpe,
                //                'email'    => $request->rpe . '@cfe.mx',
                'password' => $request->password,
                'estatus' => 2
            ])) {
                $user = User::firstWhere('rpe', $request->rpe);
            } else {
                $user = null;
            }

            return $user;
        });
    }
}

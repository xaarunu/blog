<?php

use App\Models\User;
use App\Models\Notificacion;
use FontLib\Table\Type\name;
use App\Exports\VacationDays;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\AudiometriasController;
use App\Http\Controllers\MiSaludController;
use App\Http\Controllers\SoporteController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\DatosuserController;
use App\Http\Controllers\EntregaRecepcionController;
use App\Http\Controllers\PersonalesController;
use App\Http\Controllers\IncapacidadController;
use App\Http\Controllers\PersonalSintomasController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\UnidadMedicaController;
use App\Http\Controllers\ReportesSaludController;
use App\Http\Controllers\VacacionesFueraController;
use App\Http\Controllers\PadecimientosPersonalController;
use App\Http\Controllers\ForceChangeDefaultPasswordController as FCDP;
use App\Http\Controllers\PrestacionLentesController;
use App\Http\Controllers\ProSaludController;
use App\Http\Controllers\UsuarioPendienteController;
use App\Models\RijSick;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route("salud.inicio");
    // return Excel::download(new VacationDays, 'users.xlsx');
});
Route::get('/csrf-token', function () {
    $token = csrf_token();
    return response()->json(['token' => $token]);
});

// Cambiar contraseñas por defecto
Route::get('/actualizar-contraseña', [FCDP::class, 'index'])->middleware('auth')->name('change.password');
Route::post('/actualizar-contraseña', [FCDP::class, 'Check'])->name('check.code');
Route::put('/actualizar-contraseña', [FCDP::class, 'ChangePassword'])->name('change.password.default');
Route::post('/redeem-code', [FCDP::class, 'ResendCode'])->name('redeem.code');

Route::middleware(['auth:sanctum', 'verified', 'datos.completos'])->group(function () {

    Route::get('/users/datosPersonales', [App\Http\Controllers\UserController::class, 'datosPersonales'])->name('users.datosPersonales');
    Route::get('/users/usuariosBaja', [App\Http\Controllers\UserController::class, 'usuariosBaja'])->name('users.usuariosBaja');
    Route::get('/users/centros', [App\Http\Controllers\UserController::class, 'centros'])->name('users.centros');
    Route::resource('users/pendientes', UsuarioPendienteController::class)->names('users.pendientes')->middleware('register.activity');
    Route::get('/users/pendientes/{id}/autorizar', [UsuarioPendienteController::class, 'autorizar'])->name('users.autorizar');
    Route::get('/users/pendientes/{id}/rechazar', [UsuarioPendienteController::class, 'destroy'])->name('users.rechazar');

    Route::get('/datosuserexcel', [App\Http\Controllers\DatosuserController::class, 'datosuserexcel']);
    Route::get('/saluds/notas_medicas/{id}', [App\Http\Controllers\MiSaludController::class, 'indice'])->name('saluds.indice');
    Route::get('/saluds/show_all/notas_medicas', [App\Http\Controllers\MiSaludController::class, 'showAllNotasMedicas'])->name('saluds.showAllNotasMedicas');
    Route::get('/saluds/reportes', [App\Http\Controllers\ReportesSaludController::class, 'show'])->name('reportesSalud.show');
    Route::get('/saluds/archivos', [App\Http\Controllers\MiSaludController::class, 'archivos'])->name('saluds.archivos');
    Route::post('/saluds/filtro/show_allNotas', [MiSaludController::class, 'filtroShow_allNotas']);

    Route::get('buscar-user/{usuario}', [App\Http\Controllers\DatosuserController::class, 'buscarUsuario']);

    Route::get('/get-subarea', function () {
        return Auth::user()->datos->subarea;
    });

    Route::post('/user/bajar', [UserController::class, 'bajar'])->name('users.bajar');
    Route::resource('users', UserController::class)->middleware('register.activity');
    Route::resource('roles', RoleController::class)->names('roles')->middleware('register.activity');
    Route::resource('calendario', CalendarController::class);
    Route::resource('soportes', SoporteController::class)->middleware('register.activity');
    Route::resource('saluds', MiSaludController::class)->middleware('register.activity');
    Route::resource('recepciones', EntregaRecepcionController::class)->names('recepcion')->middleware('register.activity');
    Route::post('/recepciones/filtro', [EntregaRecepcionController::class, 'filtrar']);
    Route::get('/saluds/crearnota/buscar', [MiSaludController::class, 'search'])->name('crearnota.search');
    Route::resource('datos', DatosuserController::class)->except(['create', 'edit', 'update'])->middleware('register.activity');
    Route::get('/incapacidades/grafica', [IncapacidadController::class, 'incapacidadesGraficaDeBarras'])->name('incapacidades.graficaIncapacidades');
    Route::post('/obtener-incapacidades', [IncapacidadController::class, 'obtenerIncapacidades'])->name('obtenerIncapacidades');
    Route::resource('incapacidades', IncapacidadController::class)->middleware('register.activity');
    Route::get('incapacidades/{id}/autorizar', [IncapacidadController::class, 'autorizar'])->name('incapacidades.autorizar');
    Route::get('incapacidades/{id}/rechazar', [IncapacidadController::class, 'rechazar'])->name('incapacidades.rechazar');
    //estadistica
    Route::resource('prosalud', ProSaludController::class)->middleware('register.activity');
    Route::get('/prosalud/{rpe}/all', [ProSaludController::class, 'historicoUsuario'])->name('prosalud.historico');
    Route::post('/prosalud/filtrar', [ProSaludController::class, 'filtrar'])->name('prosalud.filtrar');
    Route::get('/examenes', [ProSaludController::class, 'examenes'])->name('prosalud.estadistica.examenes');
    Route::post('/prosalud/filtrarSubareas', [ProSaludController::class, 'filtrarSubareas'])->name('prosalud.filtrarSubareas');
    Route::post('/prosalud/filtrarFechas', [ProSaludController::class, 'filtrarFechas'])->name('prosalud.filtrarFechas');
    Route::post('/prosalud/filtrarExamenes', [ProSaludController::class, 'filtrarExamenes'])->name('prosalud.filtrarExamenes');


    Route::get('/estadistica/personales', [PersonalesController::class, 'estadisticaGeneral'])->name('personales.estadistica.general');
    Route::post('/estadistica/filtrarPersonales', [PersonalesController::class, 'filtrarPersonales'])->name('personales.estadistica.filtrarPersonales');
    Route::get('/estadistica/prosalud', [ProSaludController::class, 'general'])->name('prosalud.estadistica.general');
    Route::get('/estadistica/indice', [ProSaludController::class, 'estadisticaDato'])->name('prosalud.estadistica.estadisticaDato');

    Route::get('/estadistica/prosalud/zona', [ProSaludController::class, 'estadisticaZona'])->name('prosalud.estadistica.zona');


    Route::get('personales/{rpe}', [App\Http\Controllers\PersonalesController::class, 'indice'])->name('personales.indice');
    Route::get('personales/{rpe}/create', [App\Http\Controllers\PersonalesController::class, 'create'])->name('personales.create');
    Route::post('personales/{rpe}', [App\Http\Controllers\PersonalesController::class, 'store'])->name('personales.store');
    Route::patch('personales/{id}/edit', [App\Http\Controllers\PersonalesController::class, 'update'])->name('personales.update');
    Route::delete('personales/{rpe}/{id}', [App\Http\Controllers\PersonalesController::class, 'destroy'])->name('personales.destroy');
    Route::resource('personales', PersonalesController::class)->except(['create', 'store', 'destroy'])->middleware('register.activity');
    Route::get('/personales/crearregistro/buscar', [PersonalesController::class, 'search'])->name('crearpersonales.search');
    Route::get('/personales/show_all/antecedentes', [App\Http\Controllers\PersonalesController::class, 'showAllAntecedentes'])->name('personales.showAllAntecedentes');
    Route::post('/personales/filtro/show_allAntecedentes', [PersonalesController::class, 'show_allAntecedentes']);
    Route::get('capacitacion/findUser', [ProSaludController::class, 'findUser'])->name('capacitacion.findUser');
    Route::get('capacitacion/buscarNombre', [ProSaludController::class, 'buscarNombre'])->name('capacitacion.buscarNombre');
    Route::post('capacitacion/update', [ProSaludController::class, 'actualiza'])->name('salud.actualiza');
    Route::delete('capacitacion/destroy/{id}', [ProSaludController::class, 'destroy'])->name('salud.destroy');

    Route::post('/filtrarUsuarios', [App\Http\Controllers\UserController::class, 'filterUsers'])->name('users.filterUsers');
    Route::post('/filtrarIncapacidades', [IncapacidadController::class, 'filtrarIncapacidades']);
    Route::get('/incapacidades/crearregistro/buscar', [IncapacidadController::class, 'search'])->name('crearincapacidad.search');
    Route::get('/incapacidades/rpe/{rpe}', [IncapacidadController::class, 'indexByRPE'])->name('incapacidades.indexByRPE');
    Route::post('/filtrarUsuariosExpedientes', [DatosuserController::class, 'filtrarUsuarios']);
    Route::post('/filtrarUsuariosEnfermedades', [PadecimientosPersonalController::class, 'filtrarUsuarios']);
    Route::post('/filtrarUsuariosAudiometrias', [AudiometriasController::class, 'filtrarAudiometrias']);
    Route::post('/fullcalenderajax', [App\Http\Controllers\CalendarController::class, 'ajax']);
    Route::post('/areas', [App\Http\Controllers\UserController::class, 'areas']);
    Route::post('/subareas', [App\Http\Controllers\UserController::class, 'subareas']);
    Route::post('/subarea', [App\Http\Controllers\UserController::class, 'subareas']);

    //Rutas para acceder al inicio de cada módulo:
    Route::get('/usuarios', [App\Http\Controllers\UserController::class, 'inicio'])->name('users.inicio');
    Route::get('/salud', [App\Http\Controllers\MiSaludController::class, 'inicio'])->name('salud.inicio');

    Route::resource('/prestaciones/lentes', PrestacionLentesController::class)->names('lentes')->middleware('register.activity');
    Route::get('/prestaciones/lentes/{rpe}/all', [PrestacionLentesController::class, 'historicoUsuario'])->name('lentes.historico');
    Route::post('/filtro-prestaciones-lentes', [PrestacionLentesController::class, 'filtrar']);

    //Rutas para acceder a ranking de incapacitados:
    Route::post('/ranking/filtro', [RankingController::class, 'rankingFiltro'])->name('ranking.filtro');
    Route::get('/ranking', [RankingController::class, 'rating'])->name('ranking');

    //Rutas para acceder a la grafica de padecimientos
    Route::get('/estadisticas/incapacidades/padecimientos', [IncapacidadController::class, 'padecimientosGrafica'])->name('estadisticas.incapacidades.padecimientos');
    Route::get('/estadisticas/incapacidades/incapacidades', [IncapacidadController::class, 'incapacidadesGrafica'])->name('estadisticas.incapacidades.incapacidades');
    Route::get('/estadisticas/prosalud/historial', [ProSaludController::class, 'graficaHistorial'])->name('estadisticas.prosalud.historial');
    Route::get('/estadisticas/incapacidades/filtrarGrafica', [IncapacidadController::class, 'filtrarGrafica'])->name('estadisticas.incapacidades.filtrarGrafica');
    Route::get('/estadisticas/incapacidades/filtrarArea', [IncapacidadController::class, 'filtrarArea'])->name('estadisticas.incapacidades.filtrarArea');
    Route::get('/estadisticas/prosalud/filtrarArea', [ProSaludController::class, 'filtrarArea'])->name('estadisticas.prosalud.filtrarArea');

    //Rutas para acceder a doping:
    Route::get('/dopings', [ProSaludController::class, 'antidopingIndex'])->name('prosalud.indexAntidoping');
    Route::get('/prosalud/crear', [ProSaludController::class, 'crear'])->name('prosalud.crear');

    //Rutas para acceder a audiometrias
    Route::resource('audiometrias', AudiometriasController::class)->middleware('register.activity');
    Route::get('/audiometrias/{rpe}/all', [AudiometriasController::class, 'historicoUsuario'])->name('audiometria.historico');
    Route::get('audiometrias/crearregistro/buscar', [AudiometriasController::class, 'search'])->name('audiometria.search');
    Route::get('estadistica/audiometrias', [AudiometriasController::class, 'estadisticas'])->name('audiometria.estadisticas');

    Route::middleware(['auth', 'UMFRole', 'register.activity'])->group(function () {
        Route::get('/unidad-medica/created', [UnidadMedicaController::class, 'created'])->name('unidad_medica.created');
        Route::post('/unidad-medica', [UnidadMedicaController::class, 'store'])->name('unidad_medica.store');
        Route::get('/unidad-medica/index', [UnidadMedicaController::class, 'index'])->name('unidad_medica.index');
        Route::get('/unidad-medica/edit/{id}', [UnidadMedicaController::class, 'edit'])->name('unidad_medica.edit');
        Route::put('/unidad-medica/update/{id}', [UnidadMedicaController::class, 'update'])->name('unidad_medica.update');
        Route::delete('/unidad-medica/{id}', [UnidadMedicaController::class, 'destroy'])->name('unidad_medica.destroy');
    });
    Route::get('/personal-padecimientos', [PadecimientosPersonalController::class, 'show'])->name('padecimientos.show');
    Route::get('/personal-sintomas', [PersonalSintomasController::class, 'index'])->name('personal_sintomas.index');
    Route::get('/personal-sintomas-atendido', [PersonalSintomasController::class, 'showPersonalAtendido'])->name('personal_sintomas_atendido.show');
    Route::get('/personal-sintomas-incapacitado', [PersonalSintomasController::class, 'showPersonalIncapacitado'])->name('personal_sintomas_incapacitado.show');
    Route::get('/personal-sintomas-incapacitado/show/{rpe}', [PersonalSintomasController::class, 'showIncapacidadPersonal'])->name('incapacidades_usuario.show');
    Route::post('/filtroPersonalSintomas', [PersonalSintomasController::class, 'filtroPersonalSintomas']);
    Route::post('/filtroPersonalIncapacitado', [PersonalSintomasController::class, 'filtroPersonalIncapacitado']);
    Route::post('/filtroPersonalSintomasAtendido', [PersonalSintomasController::class, 'filtroPersonalSintomasAtendido']);
    Route::put('/marcarAtendido/{id}', [PersonalSintomasController::class, 'marcarAtendido'])->name('personal_sintomas.marcarAtendido');
    Route::put('/marcarIncapacidad/Atendido/{id}', [PersonalSintomasController::class, 'marcarIncapacidadAtendida'])->name('personal_sintomas.marcarIncapacidadAtendida');
});

Route::middleware(['auth', 'bloquear.form.datos'])->group(function () {

    Route::get('llenar-datos-personales', [\App\Http\Controllers\DatosPersonalesController::class, 'mostrarFormulario'])
        ->name('llenar-datos-personales.form');

    Route::post('llenar-datos-personales', [\App\Http\Controllers\DatosPersonalesController::class, 'guardarDatos'])
        ->name('llenar-datos-personales.store');
});

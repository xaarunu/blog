<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SoporteController;
use App\Http\Controllers\EntregaRecepcionController;
use App\Http\Controllers\ForceChangeDefaultPasswordController as FCDP;
use App\Http\Controllers\UsuarioPendienteController;

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
    return redirect()->route("dashboard.index");
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

    Route::get('buscar-user/{usuario}', [App\Http\Controllers\DatosuserController::class, 'buscarUsuario']);

    Route::get('/get-subarea', function () {
        return Auth::user()->datos->subarea;
    });

    Route::post('/user/bajar', [UserController::class, 'bajar'])->name('users.bajar');
    Route::resource('users', UserController::class)->middleware('register.activity');
    Route::resource('roles', RoleController::class)->names('roles')->middleware('register.activity');
    //Route::resource('calendario', CalendarController::class);
    Route::resource('soportes', SoporteController::class)->middleware('register.activity');
    // Route::resource('saluds', MiSaludController::class)->middleware('register.activity');
    Route::resource('recepciones', EntregaRecepcionController::class)->names('recepcion')->middleware('register.activity');
    Route::post('/recepciones/filtro', [EntregaRecepcionController::class, 'filtrar']);


    Route::post('/filtrarUsuarios', [App\Http\Controllers\UserController::class, 'filterUsers'])->name('users.filterUsers');
    Route::post('/areas', [App\Http\Controllers\UserController::class, 'areas']);
    Route::post('/subareas', [App\Http\Controllers\UserController::class, 'subareas']);
    Route::post('/subarea', [App\Http\Controllers\UserController::class, 'subareas']);

    //Rutas para acceder al inicio de cada módulo:
    Route::get('/usuarios', [App\Http\Controllers\UserController::class, 'inicio'])->name('users.inicio');
    Route::get('/inicio', [App\Http\Controllers\InicioController::class, 'inicio'])->name('dashboard.index');

    Route::get('/blog.index', [App\Http\Controllers\BlogController::class, 'index'])->name(name: 'blogs.index');
    Route::get('/blog.crear', [App\Http\Controllers\BlogController::class, 'crear'])->name('blogs.crear');
    Route::post('/blog.crear', [App\Http\Controllers\BlogController::class, 'store'])->name('blogs.store');
    Route::get('/blog.admin', [App\Http\Controllers\BlogController::class, 'admin_index'])->name(name: 'blogs.admin');

    Route::get('/blog/{id}/ver', [App\Http\Controllers\BlogController::class, 'verBlog'])->name('blogs.verBlog');
    
    Route::get('/blog/{id}', [App\Http\Controllers\BlogController::class, 'editarBlog'])->name('blogs.editarBlog');
    Route::put('/blog/{id}', [App\Http\Controllers\BlogController::class, 'editarGuardar'])->name('blogs.editarGuardar');
    Route::delete('/blog/{id}', [App\Http\Controllers\BlogController::class, 'borrarBlog'])->name('blogs.borrarBlog');
    
    Route::get('/blog/{id}/pdf', [App\Http\Controllers\BlogController::class, 'generarPDF'])->name('blog.pdf');
    Route::get('/tarjeta/{id}/pdf', [App\Http\Controllers\BlogController::class, 'testpdf'])->name('testpdf');

});

Route::middleware(['auth', 'bloquear.form.datos'])->group(function () {

    Route::get('llenar-datos-personales', [\App\Http\Controllers\DatosPersonalesController::class, 'mostrarFormulario'])
        ->name('llenar-datos-personales.form');

    Route::post('llenar-datos-personales', [\App\Http\Controllers\DatosPersonalesController::class, 'guardarDatos'])
        ->name('llenar-datos-personales.store');
});

<?php


use App\Http\Controllers\Api\Alcaldia\AlcaldeController;
use App\Http\Controllers\Api\Alcaldia\DependenciaController;
use App\Http\Controllers\Api\Alcaldia\DirectorioDistritalController;
use App\Http\Controllers\Api\Alcaldia\FuncionMacroProcesoController;
use App\Http\Controllers\Api\Alcaldia\GabineteController;
use App\Http\Controllers\Api\Alcaldia\MacroProcesoController;
use App\Http\Controllers\Api\Alcaldia\PlanDesarrolloController;
use App\Http\Controllers\Api\Alcaldia\ProcedimientoMacroProcesoController;
use App\Http\Controllers\Api\Alcaldia\TipoProcedimientoController;
use App\Http\Controllers\Api\Disk\GaleriaController;
use App\Http\Controllers\Api\Menu\CategoriaController;
use App\Http\Controllers\Api\TipoEntidadController;
use App\Http\Controllers\Api\Usuarios\PerfilController;
use App\Http\Controllers\Api\Usuarios\PermisoController;
use App\Http\Controllers\Api\Usuarios\RoleController;
use App\Http\Controllers\Api\Usuarios\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





Route::apiResources([
    'users' => UserController::class,
    'roles' => RoleController::class,
    'permisos' => PermisoController::class,
    'categorias' => CategoriaController::class,
    'dependencias' => DependenciaController::class,
    'perfiles' => PerfilController::class,
    'gabinetes' => GabineteController::class,
    'tipo-procedimientos' => TipoProcedimientoController::class,
    'macro-procesos' => MacroProcesoController::class,
    'funcion-macro-procesos' => FuncionMacroProcesoController::class,
    'procedimientos-macro-procesos' => ProcedimientoMacroProcesoController::class,
    'alcaldes' => AlcaldeController::class,
    'plan-desarrollos' => PlanDesarrolloController::class,
    'tipo-entidads' => TipoEntidadController::class,
    'directorio-distritals' => DirectorioDistritalController::class,
    'galerias' => GaleriaController::class
]);

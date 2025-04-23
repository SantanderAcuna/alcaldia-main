<?php

use App\Http\Controllers\Api\AlcaldeController;
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\DirectorioDistritalController;
use App\Http\Controllers\Api\FuncionMacroProcesoController;
use App\Http\Controllers\Api\GabineteController;
use App\Http\Controllers\Api\GaleriaController;
use App\Http\Controllers\Api\MacroProcesoController;
use App\Http\Controllers\Api\PerfilController;
use App\Http\Controllers\Api\PermisoController;
use App\Http\Controllers\Api\PlanDeDesarrolloController;
use App\Http\Controllers\Api\ProcedimientoMacroProcesoController;
use App\Http\Controllers\Api\RolController;
use App\Http\Controllers\Api\SubdireccionController;
use App\Http\Controllers\Api\TipoEntidadController;
use App\Http\Controllers\Api\TipoProcedimientoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('alcaldes', AlcaldeController::class)->only(['index', 'show']);
Route::apiResource('categorias', CategoriaController::class)->only(['index', 'show']);
Route::apiResource('galerias', GaleriaController::class)->only(['index', 'show']);
Route::apiResource('macroprocesos', MacroProcesoController::class)->only(['index', 'show']);
Route::apiResource('tipo-procedimientos', TipoProcedimientoController::class)->only(['index', 'show']);
Route::apiResource('gabinetes', GabineteController::class)->only(['index', 'show']);
Route::apiResource('planes-desarrollo', PlanDeDesarrolloController::class)->only(['index', 'show']);
Route::apiResource('perfiles', PerfilController::class)->only(['index', 'show']);
Route::apiResource('funciones-macroproceso', FuncionMacroProcesoController::class)->only(['index', 'show']);
Route::apiResource('procedimientos-macro', ProcedimientoMacroProcesoController::class)->only(['index', 'show']);
Route::apiResource('subdirecciones', SubdireccionController::class)->only(['index', 'show']);

Route::get('alcal', [AlcaldeController::class, 'index']);



Route::prefix('admin')->middleware(['auth:sanctum', 'tieneRol:admin'])->group(function () {
    Route::apiResource('alcaldes', AlcaldeController::class)->except(['update', 'destroy']);
    Route::apiResource('categorias', CategoriaController::class)->except(['update', 'destroy']);
    Route::apiResource('galerias', GaleriaController::class)->except(['update', 'destroy']);
});


Route::prefix('superadmin')->middleware(['auth:sanctum', 'tieneRol:superadmin'])->group(function () {
    Route::apiResource('alcaldes', AlcaldeController::class);
    Route::apiResource('categorias', CategoriaController::class);
    Route::apiResource('galerias', GaleriaController::class);
    Route::apiResource('macroprocesos', MacroProcesoController::class);
    Route::apiResource('tipo-procedimientos', TipoProcedimientoController::class);
    Route::apiResource('gabinetes', GabineteController::class);
    Route::apiResource('planes-desarrollo', PlanDeDesarrolloController::class);
    Route::apiResource('perfiles', PerfilController::class);
    Route::apiResource('funciones-macroproceso', FuncionMacroProcesoController::class);
    Route::apiResource('procedimientos-macro', ProcedimientoMacroProcesoController::class);
    Route::apiResource('subdirecciones', SubdireccionController::class);
    Route::apiResource('roles', RolController::class);
    Route::apiResource('permisos', PermisoController::class);
});





// Rutas públicas
Route::apiResource('categorias', CategoriaController::class)->only(['index', 'show']);
Route::apiResource('galerias', GaleriaController::class)->only(['index', 'show']);
Route::apiResource('tipo-entidads', TipoEntidadController::class)->only(['index', 'show']);
Route::apiResource('tipo-procedimientos', TipoProcedimientoController::class)->only(['index', 'show']);
Route::apiResource('directorio-distritals', DirectorioDistritalController::class)->only(['index', 'show']);
Route::apiResource('macro-procesos', MacroProcesoController::class)->only(['index', 'show']);
Route::apiResource('alcaldes', AlcaldeController::class)->only(['index', 'show']);
Route::apiResource('funcion-macro-procesos', FuncionMacroProcesoController::class)->only(['index', 'show']);
Route::apiResource('procedimiento-macro-procesos', ProcedimientoMacroProcesoController::class)->only(['index', 'show']);
Route::apiResource('gabinetes', GabineteController::class)->only(['index', 'show']);
Route::apiResource('perfils', PerfilController::class)->only(['index', 'show']);
Route::apiResource('plan-de-desarrollos', PlanDeDesarrolloController::class)->only(['index', 'show']);
Route::apiResource('subdireccions', SubdireccionController::class)->only(['index', 'show']);
Route::apiResource('areas', AreaController::class)->only(['index', 'show']);


Route::prefix('admin')->middleware(['auth:sanctum', 'tieneRol:admin'])->group(function () {
    Route::apiResource('categorias', CategoriaController::class)->only(['index', 'show', 'store']);
    Route::apiResource('galerias', GaleriaController::class)->only(['index', 'show', 'store']);
    Route::apiResource('tipo-entidads', TipoEntidadController::class)->only(['index', 'show', 'store']);
    Route::apiResource('tipo-procedimientos', TipoProcedimientoController::class)->only(['index', 'show', 'store']);
    Route::apiResource('directorio-distritals', DirectorioDistritalController::class)->only(['index', 'show', 'store']);
    Route::apiResource('macro-procesos', MacroProcesoController::class)->only(['index', 'show', 'store']);
    Route::apiResource('alcaldes', AlcaldeController::class)->only(['index', 'show', 'store']);
    Route::apiResource('funcion-macro-procesos', FuncionMacroProcesoController::class)->only(['index', 'show', 'store']);
    Route::apiResource('procedimiento-macro-procesos', ProcedimientoMacroProcesoController::class)->only(['index', 'show', 'store']);
    Route::apiResource('gabinetes', GabineteController::class)->only(['index', 'show', 'store']);
    Route::apiResource('perfils', PerfilController::class)->only(['index', 'show', 'store']);
    Route::apiResource('plan-de-desarrollos', PlanDeDesarrolloController::class)->only(['index', 'show', 'store']);
    Route::apiResource('subdireccions', SubdireccionController::class)->only(['index', 'show', 'store']);
    Route::apiResource('areas', AreaController::class)->only(['index', 'show', 'store']);
});

Route::prefix('superadmin')->middleware(['auth:sanctum', 'tieneRol:superadmin'])->group(function () {
    Route::apiResource('categorias', CategoriaController::class);
    Route::apiResource('galerias', GaleriaController::class);
    Route::apiResource('tipo-entidads', TipoEntidadController::class);
    Route::apiResource('tipo-procedimientos', TipoProcedimientoController::class);
    Route::apiResource('directorio-distritals', DirectorioDistritalController::class);
    Route::apiResource('macro-procesos', MacroProcesoController::class);
    Route::apiResource('alcaldes', AlcaldeController::class);
    Route::apiResource('funcion-macro-procesos', FuncionMacroProcesoController::class);
    Route::apiResource('procedimiento-macro-procesos', ProcedimientoMacroProcesoController::class);
    Route::apiResource('gabinetes', GabineteController::class);
    Route::apiResource('perfils', PerfilController::class);
    Route::apiResource('plan-de-desarrollos', PlanDeDesarrolloController::class);
    Route::apiResource('subdireccions', SubdireccionController::class);
    Route::apiResource('areas', AreaController::class);
});

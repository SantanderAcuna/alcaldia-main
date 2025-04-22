<?php

use App\Http\Controllers\Api\Alcaldia\Admin\AlcaldeAdminController;
use App\Http\Controllers\Api\Alcaldia\Admin\AreaAdminController;
use App\Http\Controllers\Api\Alcaldia\Admin\FuncionMacroProcesoAdminController;
use App\Http\Controllers\Api\Alcaldia\Admin\GabineteAdminController;
use App\Http\Controllers\Api\Alcaldia\Admin\MacroProcesoAdminController;
use App\Http\Controllers\Api\Alcaldia\Admin\PlanDeDesarrolloAdminController;
use App\Http\Controllers\Api\Alcaldia\Admin\ProcedimientoMacroProcesoAdminController;
use App\Http\Controllers\Api\Alcaldia\Admin\SubdireccionAdminController;
use App\Http\Controllers\Api\Alcaldia\Admin\TipoProcedimientoAdminController;
use App\Http\Controllers\Api\Alcaldia\Publico\AlcaldePublicoController;
use App\Http\Controllers\Api\Alcaldia\Publico\AreaPublicoController;
use App\Http\Controllers\Api\Alcaldia\Publico\FuncionMacroProcesoPublicoController;
use App\Http\Controllers\Api\Alcaldia\Publico\GabinetePublicoController;
use App\Http\Controllers\Api\Alcaldia\Publico\MacroProcesoPublicoController;
use App\Http\Controllers\Api\Alcaldia\Publico\PlanDeDesarrolloPublicoController;
use App\Http\Controllers\Api\Alcaldia\Publico\ProcedimientoMacroProcesoPublicoController;
use App\Http\Controllers\Api\Alcaldia\Publico\SubdireccionPublicoController;
use App\Http\Controllers\Api\Alcaldia\Publico\TipoProcedimientoPublicoController;
use App\Http\Controllers\Api\Alcaldia\Superadmin\AlcaldeSuperAdminController;
use App\Http\Controllers\Api\Alcaldia\Superadmin\AreaSuperAdminController;
use App\Http\Controllers\Api\Alcaldia\SuperAdmin\FuncionMacroProcesoSuperAdminController;
use App\Http\Controllers\Api\Alcaldia\SuperAdmin\GabineteSuperAdminController;
use App\Http\Controllers\Api\Alcaldia\SuperAdmin\MacroProcesoSuperAdminController;
use App\Http\Controllers\Api\Alcaldia\SuperAdmin\PlanDeDesarrolloSuperAdminController;
use App\Http\Controllers\Api\Alcaldia\Superadmin\ProcedimientoMacroProcesoSuperAdminController;
use App\Http\Controllers\Api\Alcaldia\Superadmin\SubdireccionSuperAdminController;
use App\Http\Controllers\Api\Alcaldia\SuperAdmin\TipoProcedimientoSuperAdminController;
use App\Http\Controllers\Api\Categoria\Admin\CategoriaAdminController;
use App\Http\Controllers\Api\Categoria\Publico\CategoriaPublicoController;
use App\Http\Controllers\Api\Categoria\SuperAdmin\CategoriaSuperAdminController;
use App\Http\Controllers\Api\Galeria\Admin\GaleriaAdminController;
use App\Http\Controllers\Api\Galeria\Publico\GaleriaPublicoController;
use App\Http\Controllers\Api\Galeria\SuperAdmin\GaleriaSuperAdminController;
use App\Http\Controllers\Api\Usuarios\PerfilAdminController;
use App\Http\Controllers\Api\Usuarios\PerfilPublicoController;
use App\Http\Controllers\Api\Usuarios\PerfilSuperAdminController;
use App\Http\Controllers\Api\Usuarios\Seguridad\RolesSuperAdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Rutas públicas (sin autenticación)
Route::prefix('alcaldia/publico')->group(function () {
    // Alcaldes
    Route::apiResource('alcaldes', AlcaldePublicoController::class)->only(['index', 'show']);

    // Categorías
    Route::apiResource('categorias', CategoriaPublicoController::class)->only(['index', 'show']);

    // Galería
    Route::get('galerias', [GaleriaPublicoController::class, 'index']);
    Route::get('galerias/{galeria}', [GaleriaPublicoController::class, 'show']);

    // Macroprocesos
    Route::get('macroprocesos', [MacroProcesoPublicoController::class, 'index']);
    Route::get('macroprocesos/{macroProceso}', [MacroProcesoPublicoController::class, 'show']);

    // Tipo de procedimientos
    Route::get('tipo-procedimientos', [TipoProcedimientoPublicoController::class, 'index']);
    Route::get('tipo-procedimientos/{tipoProcedimiento}', [TipoProcedimientoPublicoController::class, 'show']);

    // Gabinetes
    Route::get('gabinetes', [GabinetePublicoController::class, 'index']);
    Route::get('gabinetes/{gabinete}', [GabinetePublicoController::class, 'show']);

    // Planes de desarrollo
    Route::get('planes-desarrollo', [PlanDeDesarrolloPublicoController::class, 'index']);
    Route::get('planes-desarrollo/{plan}', [PlanDeDesarrolloPublicoController::class, 'show']);

    // Perfiles
    Route::get('perfiles', [PerfilPublicoController::class, 'index']);
    Route::get('perfiles/{perfil}', [PerfilPublicoController::class, 'show']);

    // Funciones macroproceso
    Route::get('funciones-macroproceso', [FuncionMacroProcesoPublicoController::class, 'index']);
    Route::get('funciones-macroproceso/{funcionMacroProceso}', [FuncionMacroProcesoPublicoController::class, 'show']);

    // Procedimientos macro
    Route::get('procedimientos-macro', [ProcedimientoMacroProcesoPublicoController::class, 'index']);
    Route::get('procedimientos-macro/{procedimiento}', [ProcedimientoMacroProcesoPublicoController::class, 'show']);

    // Subdirecciones
    Route::get('subdirecciones', [SubdireccionPublicoController::class, 'index']);
    Route::get('subdirecciones/{subdireccion}', [SubdireccionPublicoController::class, 'show']);

    // Áreas
    Route::get('subdirecciones/{subdireccion}/areas', [AreaPublicoController::class, 'index']);
    Route::get('subdirecciones/{subdireccion}/areas/{area}', [AreaPublicoController::class, 'show']);
});

// Rutas para administradores
Route::prefix('alcaldia/admin')->middleware(['auth:sanctum', 'tieneRol:admin'])->group(function () {
    // Alcaldes
    Route::apiResource('alcaldes', AlcaldeAdminController::class)->only(['index', 'show', 'store']);

    // Categorías
    Route::apiResource('categorias', CategoriaAdminController::class)->only(['index', 'show', 'store']);

    // Galería
    Route::apiResource('galerias', GaleriaAdminController::class)->except(['update', 'destroy']);

    // Macroprocesos (con roles específicos)
    Route::middleware('tieneRol:editor_procesos')->apiResource('macroprocesos', MacroProcesoAdminController::class)
        ->except(['update', 'destroy']);

    // Tipo procedimientos (con roles específicos)
    Route::middleware('tieneRol:editor_procesos')->apiResource('tipo-procedimientos', TipoProcedimientoAdminController::class)
        ->except(['update', 'destroy']);

    // Gabinetes (con roles específicos)
    Route::middleware('tieneRol:editor_gabinete')->apiResource('gabinetes', GabineteAdminController::class)
        ->except(['update', 'destroy']);

    // Planes desarrollo (con roles específicos)
    Route::middleware('tieneRol:editor_planes')->apiResource('planes-desarrollo', PlanDeDesarrolloAdminController::class)
        ->except(['update', 'destroy']);

    // Perfiles (con roles específicos)
    Route::middleware('tieneRol:editor_perfiles')->apiResource('perfiles', PerfilAdminController::class)
        ->except(['update', 'destroy']);

    // Funciones macroproceso (con roles específicos)
    Route::middleware('tieneRol:editor_procesos')->apiResource('funciones-macroproceso', FuncionMacroProcesoAdminController::class)
        ->except(['update', 'destroy']);

    // Procedimientos macro
    Route::post('procedimientos-macro', [ProcedimientoMacroProcesoAdminController::class, 'store']);

    // Subdirecciones
    Route::post('subdirecciones', [SubdireccionAdminController::class, 'store']);

    // Áreas
    Route::post('subdirecciones/{subdireccion}/areas', [AreaAdminController::class, 'store']);
});

// Rutas para superadministradores
Route::prefix('alcaldia/superadmin')->middleware(['auth:sanctum', 'tieneRol:superadmin'])->group(function () {
    // Alcaldes
    Route::apiResource('alcaldes', AlcaldeSuperAdminController::class);

    // Categorías
    Route::apiResource('categorias', CategoriaSuperAdminController::class);

    // Galería
    Route::apiResource('galerias', GaleriaSuperAdminController::class);

    // Macroprocesos
    Route::apiResource('macroprocesos', MacroProcesoSuperAdminController::class);
    Route::post('macroprocesos/{id}/restore', [MacroProcesoSuperAdminController::class, 'restore']);

    // Tipo procedimientos
    Route::put('tipo-procedimientos/{tipoProcedimiento}', [TipoProcedimientoSuperAdminController::class, 'update']);
    Route::delete('tipo-procedimientos/{tipoProcedimiento}', [TipoProcedimientoSuperAdminController::class, 'destroy']);

    // Gabinetes
    Route::put('gabinetes/{gabinete}', [GabineteSuperAdminController::class, 'update']);
    Route::delete('gabinetes/{gabinete}', [GabineteSuperAdminController::class, 'destroy']);
    Route::post('gabinetes/{id}/restore', [GabineteSuperAdminController::class, 'restore']);

    // Planes desarrollo
    Route::put('planes-desarrollo/{plan}', [PlanDeDesarrolloSuperAdminController::class, 'update']);
    Route::delete('planes-desarrollo/{plan}', [PlanDeDesarrolloSuperAdminController::class, 'destroy']);
    Route::post('planes-desarrollo/{id}/restore', [PlanDeDesarrolloSuperAdminController::class, 'restore']);

    // Perfiles
    Route::put('perfiles/{perfil}', [PerfilSuperAdminController::class, 'update']);
    Route::delete('perfiles/{perfil}', [PerfilSuperAdminController::class, 'destroy']);

    // Funciones macroproceso
    Route::put('funciones-macroproceso/{funcionMacroProceso}', [FuncionMacroProcesoSuperAdminController::class, 'update']);
    Route::delete('funciones-macroproceso/{funcionMacroProceso}', [FuncionMacroProcesoSuperAdminController::class, 'destroy']);
    Route::post('funciones-macroproceso/{id}/restore', [FuncionMacroProcesoSuperAdminController::class, 'restore']);

    // Procedimientos macro
    Route::put('procedimientos-macro/{procedimiento}', [ProcedimientoMacroProcesoSuperAdminController::class, 'update']);
    Route::delete('procedimientos-macro/{procedimiento}', [ProcedimientoMacroProcesoSuperAdminController::class, 'destroy']);

    // Subdirecciones
    Route::put('subdirecciones/{subdireccion}', [SubdireccionSuperAdminController::class, 'update']);
    Route::delete('subdirecciones/{subdireccion}', [SubdireccionSuperAdminController::class, 'destroy']);

    // Áreas
    Route::put('subdirecciones/{subdireccion}/areas/{area}', [AreaSuperAdminController::class, 'update']);
    Route::delete('subdirecciones/{subdireccion}/areas/{area}', [AreaSuperAdminController::class, 'destroy']);
});

// Rutas de seguridad (solo superadmin)
Route::prefix('seguridad/superadmin')->middleware(['auth:sanctum', 'tieneRol:superadmin'])->group(function () {
    Route::apiResource('roles', RolesSuperAdminController::class);
    Route::post('roles/{role}/permisos', [RolesSuperAdminController::class, 'asignarPermisos']);
});

// Ruta de autenticación
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

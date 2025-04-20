<?php


use App\Http\Controllers\Api\Alcaldia\Admin\AlcaldeAdminController;
use App\Http\Controllers\Api\Alcaldia\Admin\FuncionMacroProcesoAdminController;
use App\Http\Controllers\Api\Alcaldia\Admin\GabineteAdminController;
use App\Http\Controllers\Api\Alcaldia\Admin\MacroProcesoAdminController;
use App\Http\Controllers\Api\Alcaldia\Admin\PlanDeDesarrolloAdminController;
use App\Http\Controllers\Api\Alcaldia\Admin\ProcedimientoMacroProcesoAdminController;
use App\Http\Controllers\Api\Alcaldia\Admin\TipoProcedimientoAdminController;
use App\Http\Controllers\Api\Alcaldia\Publico\AlcaldePublicoController;
use App\Http\Controllers\Api\Alcaldia\Publico\FuncionMacroProcesoPublicoController;
use App\Http\Controllers\Api\Alcaldia\Publico\GabinetePublicoController;
use App\Http\Controllers\Api\Alcaldia\Publico\MacroProcesoPublicoController;
use App\Http\Controllers\Api\Alcaldia\Publico\PlanDeDesarrolloPublicoController;
use App\Http\Controllers\Api\Alcaldia\Publico\ProcedimientoMacroProcesoPublicoController;
use App\Http\Controllers\Api\Alcaldia\Publico\TipoProcedimientoPublicoController;
use App\Http\Controllers\Api\Alcaldia\Superadmin\AlcaldeSuperAdminController;
use App\Http\Controllers\Api\Alcaldia\SuperAdmin\FuncionMacroProcesoSuperAdminController;
use App\Http\Controllers\Api\Alcaldia\SuperAdmin\GabineteSuperAdminController;
use App\Http\Controllers\Api\Alcaldia\SuperAdmin\MacroProcesoSuperAdminController;
use App\Http\Controllers\Api\Alcaldia\SuperAdmin\PlanDeDesarrolloSuperAdminController;
use App\Http\Controllers\Api\Alcaldia\Superadmin\ProcedimientoMacroProcesoSuperAdminController;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas para superadministradores

Route::prefix('alcaldia/superadmin')
    ->middleware(['auth:sanctum', 'tieneRol:superadmin'])
    ->group(function () {
        Route::apiResource('alcaldes', AlcaldeSuperAdminController::class);
        Route::apiResource('categorias', CategoriaSuperAdminController::class);
        Route::apiResource('/', GaleriaSuperAdminController::class);
    });


// Rutas para administradores
Route::prefix('alcaldia/admin')
    ->middleware(['auth:sanctum', 'tieneRol:admin'])
    ->group(function () {
        Route::apiResource('alcaldes', AlcaldeAdminController::class)
            ->only(['index', 'show', 'store']);

        Route::apiResource('categorias', CategoriaAdminController::class)
            ->only(['index', 'show', 'store']);

        Route::apiResource('/', GaleriaAdminController::class)
            ->except(['update', 'destroy']);
    });



// Rutas públicas

Route::apiResource('alcaldes', AlcaldePublicoController::class)
    ->only(['index', 'show']);

Route::apiResource('categorias', CategoriaPublicoController::class)
    ->only(['index', 'show']);

Route::get('/', [GaleriaPublicoController::class, 'index']);
Route::get('/{galeria}', [GaleriaPublicoController::class, 'show']);



// Publico
Route::prefix('alcaldia/publico')->group(function () {
    Route::get('macroprocesos', [MacroProcesoPublicoController::class, 'index']);
    Route::get('macroprocesos/{macroProceso}', [MacroProcesoPublicoController::class, 'show']);
});

// Admin
Route::prefix('alcaldia/admin')->middleware(['auth:sanctum', 'tieneRol:admin,editor_procesos'])->group(function () {
    Route::apiResource('macroprocesos', MacroProcesoAdminController::class)
        ->except(['update', 'destroy']);
});

// routes/api.php
Route::prefix('alcaldia/superadmin')->middleware(['auth:sanctum', 'role:superadmin'])->group(function () {
    // MacroProcesos
    Route::get('macroprocesos', [MacroProcesoSuperAdminController::class, 'index']);
    Route::get('macroprocesos/{macroProceso}', [MacroProcesoSuperAdminController::class, 'show']);
    Route::post('macroprocesos', [MacroProcesoSuperAdminController::class, 'store']);
    Route::put('macroprocesos/{macroProceso}', [MacroProcesoSuperAdminController::class, 'update']);
    Route::delete('macroprocesos/{macroProceso}', [MacroProcesoSuperAdminController::class, 'destroy']);
    Route::post('macroprocesos/{id}/restore', [MacroProcesoSuperAdminController::class, 'restore']);
});


// Publico
Route::prefix('alcaldia/publico')->group(function () {
    Route::get('tipo-procedimientos', [TipoProcedimientoPublicoController::class, 'index']);
    Route::get('tipo-procedimientos/{tipoProcedimiento}', [TipoProcedimientoPublicoController::class, 'show']);
});

// Admin
Route::prefix('alcaldia/admin')->middleware(['auth:sanctum', 'tieneRol:admin,editor_procesos'])->group(function () {
    Route::apiResource('tipo-procedimientos', TipoProcedimientoAdminController::class)->except(['update', 'destroy']);
});

// SuperAdmin
Route::prefix('alcaldia/superadmin')->middleware(['auth:sanctum', 'tieneRol:superadmin'])->group(function () {
    Route::put('tipo-procedimientos/{tipoProcedimiento}', [TipoProcedimientoSuperAdminController::class, 'update']);
    Route::delete('tipo-procedimientos/{tipoProcedimiento}', [TipoProcedimientoSuperAdminController::class, 'destroy']);
});

// Publico
Route::prefix('alcaldia/publico')->group(function () {
    Route::get('gabinetes', [GabinetePublicoController::class, 'index']);
    Route::get('gabinetes/{gabinete}', [GabinetePublicoController::class, 'show']);
});

// Admin
Route::prefix('alcaldia/admin')->middleware(['auth:sanctum', 'tieneRol:admin,editor_gabinete'])->group(function () {
    Route::apiResource('gabinetes', GabineteAdminController::class)->except(['update', 'destroy']);
});

// SuperAdmin
Route::prefix('alcaldia/superadmin')->middleware(['auth:sanctum', 'tieneRol:superadmin'])->group(function () {
    Route::put('gabinetes/{gabinete}', [GabineteSuperAdminController::class, 'update']);
    Route::delete('gabinetes/{gabinete}', [GabineteSuperAdminController::class, 'destroy']);
    Route::post('gabinetes/{id}/restore', [GabineteSuperAdminController::class, 'restore']);
});


// Publico
Route::prefix('alcaldia/publico')->group(function () {
    Route::get('planes-desarrollo', [PlanDeDesarrolloPublicoController::class, 'index']);
    Route::get('planes-desarrollo/{plan}', [PlanDeDesarrolloPublicoController::class, 'show']);
});

// Admin
Route::prefix('alcaldia/admin')->middleware(['auth:sanctum', 'tieneRol:admin,editor_planes'])->group(function () {
    Route::apiResource('planes-desarrollo', PlanDeDesarrolloAdminController::class)->except(['update', 'destroy']);
});

// SuperAdmin
Route::prefix('alcaldia/superadmin')->middleware(['auth:sanctum', 'tieneRol:superadmin'])->group(function () {
    Route::put('planes-desarrollo/{plan}', [PlanDeDesarrolloSuperAdminController::class, 'update']);
    Route::delete('planes-desarrollo/{plan}', [PlanDeDesarrolloSuperAdminController::class, 'destroy']);
    Route::post('planes-desarrollo/{id}/restore', [PlanDeDesarrolloSuperAdminController::class, 'restore']);
});


// Publico
Route::prefix('alcaldia/publico')->group(function () {
    Route::get('perfiles', [PerfilPublicoController::class, 'index']);
    Route::get('perfiles/{perfil}', [PerfilPublicoController::class, 'show']);
});

// Admin
Route::prefix('alcaldia/admin')->middleware(['auth:sanctum', 'tieneRol:admin,editor_perfiles'])->group(function () {
    Route::apiResource('perfiles', PerfilAdminController::class)->except(['update', 'destroy']);
});

// SuperAdmin
Route::prefix('alcaldia/superadmin')->middleware(['auth:sanctum', 'tieneRol:superadmin'])->group(function () {
    Route::put('perfiles/{perfil}', [PerfilSuperAdminController::class, 'update']);
    Route::delete('perfiles/{perfil}', [PerfilSuperAdminController::class, 'destroy']);
});


Route::prefix('seguridad/superadmin')->middleware(['auth:sanctum', 'tieneRol:superadmin'])->group(function () {
    Route::apiResource('roles', RolesSuperAdminController::class);
    Route::post('roles/{role}/permisos', [RolesSuperAdminController::class, 'asignarPermisos']);
});



// Publico
Route::prefix('alcaldia/publico')->group(function () {
    Route::get('funciones-macroproceso', [FuncionMacroProcesoPublicoController::class, 'index']);
    Route::get('funciones-macroproceso/{funcionMacroProceso}', [FuncionMacroProcesoPublicoController::class, 'show']);
});

// Admin
Route::prefix('alcaldia/admin')->middleware(['auth:sanctum', 'tieneRol:admin,editor_procesos'])->group(function () {
    Route::apiResource('funciones-macroproceso', FuncionMacroProcesoAdminController::class)->except(['update', 'destroy']);
});

// SuperAdmin
Route::prefix('alcaldia/superadmin')->middleware(['auth:sanctum', 'tieneRol:superadmin'])->group(function () {
    Route::put('funciones-macroproceso/{funcionMacroProceso}', [FuncionMacroProcesoSuperAdminController::class, 'update']);
    Route::delete('funciones-macroproceso/{funcionMacroProceso}', [FuncionMacroProcesoSuperAdminController::class, 'destroy']);
    Route::post('funciones-macroproceso/{id}/restore', [FuncionMacroProcesoSuperAdminController::class, 'restore']);
});


// routes/api.php
Route::prefix('procedimientos-macro')->group(function () {
    // Público
    Route::get('/', [ProcedimientoMacroProcesoPublicoController::class, 'index']);
    Route::get('/{procedimiento}', [ProcedimientoMacroProcesoPublicoController::class, 'show']);

    // Admin
    Route::middleware(['auth:sanctum', 'role:admin'])->post('/', [ProcedimientoMacroProcesoAdminController::class, 'store']);

    // SuperAdmin
    Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function () {
        Route::put('/{procedimiento}', [ProcedimientoMacroProcesoSuperAdminController::class, 'update']);
        Route::delete('/{procedimiento}', [ProcedimientoMacroProcesoSuperAdminController::class, 'destroy']);
    });

});


// Procedimientos Macroproceso
Route::prefix('procedimientos-macro')->group(function () {
    // Público
    Route::get('/', [\App\Http\Controllers\Api\Alcaldia\Publico\ProcedimientoMacroProcesoPublicoController::class, 'index']);
    Route::get('/{procedimiento}', [\App\Http\Controllers\Api\Alcaldia\Publico\ProcedimientoMacroProcesoPublicoController::class, 'show']);

    // Admin
    Route::middleware(['auth:sanctum', 'role:admin'])->post('/', [\App\Http\Controllers\Api\Alcaldia\Admin\ProcedimientoMacroProcesoAdminController::class, 'store']);

    // SuperAdmin
    Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function () {
        Route::put('/{procedimiento}', [\App\Http\Controllers\Api\Alcaldia\Superadmin\ProcedimientoMacroProcesoSuperAdminController::class, 'update']);
        Route::delete('/{procedimiento}', [\App\Http\Controllers\Api\Alcaldia\Superadmin\ProcedimientoMacroProcesoSuperAdminController::class, 'destroy']);
    });
});


// Subdirecciones
Route::prefix('subdirecciones')->group(function () {
    // Público
    Route::get('/', [\App\Http\Controllers\Api\Alcaldia\Publico\SubdireccionPublicoController::class, 'index']);
    Route::get('/{subdireccion}', [\App\Http\Controllers\Api\Alcaldia\Publico\SubdireccionPublicoController::class, 'show']);

    // Admin
    Route::middleware(['auth:sanctum', 'role:admin'])->post('/', [\App\Http\Controllers\Api\Alcaldia\Admin\SubdireccionAdminController::class, 'store']);

    // SuperAdmin
    Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function () {
        Route::put('/{subdireccion}', [\App\Http\Controllers\Api\Alcaldia\Superadmin\SubdireccionSuperAdminController::class, 'update']);
        Route::delete('/{subdireccion}', [\App\Http\Controllers\Api\Alcaldia\Superadmin\SubdireccionSuperAdminController::class, 'destroy']);
    });
});


// Áreas (dentro de Subdirecciones)
Route::prefix('subdirecciones/{subdireccion}/areas')->group(function () {
    // Público
    Route::get('/', [\App\Http\Controllers\Api\Alcaldia\Publico\AreaPublicoController::class, 'index']);
    Route::get('/{area}', [\App\Http\Controllers\Api\Alcaldia\Publico\AreaPublicoController::class, 'show']);

    // Admin
    Route::middleware(['auth:sanctum', 'role:admin'])->post('/', [\App\Http\Controllers\Api\Alcaldia\Admin\AreaAdminController::class, 'store']);

    // SuperAdmin
    Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function () {
        Route::put('/{area}', [\App\Http\Controllers\Api\Alcaldia\Superadmin\AreaSuperAdminController::class, 'update']);
        Route::delete('/{area}', [\App\Http\Controllers\Api\Alcaldia\Superadmin\AreaSuperAdminController::class, 'destroy']);
    });
});

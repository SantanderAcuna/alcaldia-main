<?php

use App\Http\Controllers\api\admin\AlcaldeAdminController;
use App\Http\Controllers\api\admin\DependenciaAdminController;
use App\Http\Controllers\api\admin\DocumentoAdminController;
use App\Http\Controllers\api\admin\FotoAdminController;
use App\Http\Controllers\api\admin\FuncionarioAdminController;
use App\Http\Controllers\api\admin\FuncioneSecAdminController;
use App\Http\Controllers\api\admin\PerfilAdminController;
use App\Http\Controllers\api\admin\PlanDesarrolloAdminController;
use App\Http\Controllers\api\admin\PublicacionAdminController;
use App\Http\Controllers\api\admin\SecretariaAdminController;
use App\Http\Controllers\api\admin\TagAdminController;
use App\Http\Controllers\api\admin\TipoAdminController;
use App\Http\Controllers\api\admin\TramiteAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\publico\AlcaldeController;
use App\Http\Controllers\api\publico\DependenciaController;
use App\Http\Controllers\api\publico\DirectorioController;
use App\Http\Controllers\api\publico\DocumentoController;
use App\Http\Controllers\api\publico\FotoController;
use App\Http\Controllers\api\publico\FuncionarioController;
use App\Http\Controllers\api\publico\Funciones_secController;
use App\Http\Controllers\api\publico\PerfilController;
use App\Http\Controllers\api\publico\PlanDeDesarrolloController;
use App\Http\Controllers\api\publico\PublicacionController;
use App\Http\Controllers\api\publico\SecretariaController;
use App\Http\Controllers\api\publico\TagController;
use App\Http\Controllers\api\publico\TipoController;
use App\Http\Controllers\api\publico\TramiteController;
use App\Http\Controllers\api\UploadController;

// CRUD de Plan de Desarrollo

Route::apiResource('uploads', UploadController::class);



Route::prefix('publico')->group(function () {

    Route::apiResource('alcaldes', AlcaldeController::class);
    Route::apiResource('plan', PlanDeDesarrolloController::class);
    // Funcionarios

    Route::apiResource('funcionarios', FuncionarioController::class);
    Route::apiResource('perfiles', PerfilController::class);

    // Secretaria

    Route::apiResource('secretarias', SecretariaController::class);
    Route::apiResource('dependencias', DependenciaController::class);
    Route::apiResource('funciones', Funciones_secController::class);
    Route::apiResource('tramites', TramiteController::class);

    // Publicaciones

    Route::apiResource('publicaciones', PublicacionController::class);
    Route::apiResource('documentos', DocumentoController::class);
    Route::apiResource('fotos', FotoController::class);


    // Directorio Distrital

    Route::apiResource('directorio-distrital', DirectorioController::class);
    Route::apiResource('tipos', TipoController::class);
    Route::apiResource('tags', TagController::class);
});




Route::prefix('admin')->group(function () {

    Route::apiResource('alcaldes', AlcaldeAdminController::class);
    Route::apiResource('plan-admin', PlanDesarrolloAdminController::class);
    // Funcionarios

    Route::apiResource('funcionarios-admin', FuncionarioAdminController::class);
    Route::apiResource('perfiles-admin', PerfilAdminController::class);

    // Secretaria

    Route::apiResource('secretarias-admin', SecretariaAdminController::class);
    Route::apiResource('dependencias-admin', DependenciaAdminController::class);
    Route::apiResource('funciones-admin', FuncioneSecAdminController::class);
    Route::apiResource('tramites-admin', TramiteAdminController::class);

    // Publicaciones

    Route::apiResource('publicaciones-admin', PublicacionAdminController::class);
    Route::apiResource('documentos-admin', DocumentoAdminController::class);
    Route::apiResource('fotos-admin', FotoAdminController::class);


    // Directorio Distrital

    Route::apiResource('directorio-distrital-admin', DirectorioController::class);
    Route::apiResource('tipos-admin', TipoAdminController::class);
    Route::apiResource('tags-admin', TagAdminController::class);
});

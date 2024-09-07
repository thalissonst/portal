<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\EstadoController;
use App\Http\Controllers\Api\CidadeController;

Route::middleware('api')->group(function () {

    Route::post('/login', [UsuarioController::class, 'loginUser']); // Rota que realiza o login do usuário

    Route::apiResource('users', UsuarioController::class);
    Route::apiResource('customers', ClienteController::class);
    Route::apiResource('states', EstadoController::class);
    Route::apiResource('cities', CidadeController::class);

    Route::get('/cities/states/{id}', [CidadeController::class, 'citiesStates']); // Rota para buscar as cidades de um estado
       
});




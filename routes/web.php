<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;


//Route::get('/', function () {
//    return view('welcome');
//});
Route::view('/', 'produtos.index');
    Route::get('/produtos', [ProdutoController::class, 'index']);
    Route::get('/produtos/search', [ProdutoController::class, 'search']);
    Route::get('/produtos/{id}', [ProdutoController::class, 'show']);
    Route::post('/produtos', [ProdutoController::class, 'store']);
    Route::put('/produtos/{id}', [ProdutoController::class, 'update']);
    Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);

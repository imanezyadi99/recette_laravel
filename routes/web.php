<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Routes pour la gestion des recettes
    Route::resource('recipes', RecipeController::class);
    Route::get('/recipes', [RecipeController::class, 'index'])->name('index');
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout1');


    // Route pour la recherche de recettes
    Route::get('/search', [RecipeController::class, 'search'])->name('search');
});



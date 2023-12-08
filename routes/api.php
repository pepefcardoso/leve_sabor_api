<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\CookingStyleController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([],
    function (Router $router) {
        $router->get('user', function (Request $request) {
            return $request->user();
        });

        $router->get('diets', [DietController::class, 'index']);
        $router->post('diets', [DietController::class, 'store']);
        $router->get('diets/{id}', [DietController::class, 'show']);
        $router->put('diets/{id}', [DietController::class, 'update']);
        $router->delete('diets/{id}', [DietController::class, 'destroy']);

        $router->get('categories', [CategoryController::class, 'index']);
        $router->post('categories', [CategoryController::class, 'store']);
        $router->get('categories/{id}', [CategoryController::class, 'show']);
        $router->put('categories/{id}', [CategoryController::class, 'update']);
        $router->delete('categories/{id}', [CategoryController::class, 'destroy']);

        $router->get('phones', [PhoneController::class, 'index']);
        $router->post('phones', [PhoneController::class, 'store']);
        $router->get('phones/{id}', [PhoneController::class, 'show']);
        $router->put('phones/{id}', [PhoneController::class, 'update']);
        $router->delete('phones/{id}', [PhoneController::class, 'destroy']);

        $router->get('cooking-styles', [CookingStyleController::class, 'index']);
        $router->post('cooking-styles', [CookingStyleController::class, 'store']);
        $router->get('cooking-styles/{id}', [CookingStyleController::class, 'show']);
        $router->put('cooking-styles/{id}', [CookingStyleController::class, 'update']);
        $router->delete('cooking-styles/{id}', [CookingStyleController::class, 'destroy']);
    });

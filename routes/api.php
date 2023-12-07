<?php

use App\Http\Controllers\DietController;
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

        $router->get('categories', [DietController::class, 'index']);
        $router->post('categories', [DietController::class, 'store']);
        $router->get('categories/{id}', [DietController::class, 'show']);
        $router->put('categories/{id}', [DietController::class, 'update']);
        $router->delete('categories/{id}', [DietController::class, 'destroy']);
    });

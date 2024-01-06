<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusinessImageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\CookingStyleController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\OpeningHoursController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserBusinessController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserImageController;
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

Route::prefix('api')
    ->middleware(['auth:api', 'role:admin'])
    ->group(
        function (Router $router) {
            $router->post('diets', [DietController::class, 'store']);
            $router->get('diets/{id}', [DietController::class, 'show']);
            $router->put('diets/{id}', [DietController::class, 'update']);
            $router->delete('diets/{id}', [DietController::class, 'destroy']);

            $router->post('categories', [CategoryController::class, 'store']);
            $router->get('categories/{id}', [CategoryController::class, 'show']);
            $router->put('categories/{id}', [CategoryController::class, 'update']);
            $router->delete('categories/{id}', [CategoryController::class, 'destroy']);

            $router->post('cooking-styles', [CookingStyleController::class, 'store']);
            $router->get('cooking-styles/{id}', [CookingStyleController::class, 'show']);
            $router->put('cooking-styles/{id}', [CookingStyleController::class, 'update']);
            $router->delete('cooking-styles/{id}', [CookingStyleController::class, 'destroy']);

            $router->get('roles', [RoleController::class, 'index']);
            $router->post('roles', [RoleController::class, 'store']);
            $router->get('roles/{id}', [RoleController::class, 'show']);
            $router->put('roles/{id}', [RoleController::class, 'update']);
            $router->delete('roles/{id}', [RoleController::class, 'destroy']);
        });

Route::prefix('api')
    ->group(
        function (Router $router) {
            $router->post('register', [UserController::class, 'store']);

            $router->post('login', [UserController::class, 'login']);

            $router->get('diets', [DietController::class, 'index']);

            $router->get('categories', [CategoryController::class, 'index']);

            $router->get('cooking-styles', [CookingStyleController::class, 'index']);

            $router->get('contacts/{contactId}/phones', [PhoneController::class, 'index']);

            $router->get('business/{businessId}/contacts', [ContactsController::class, 'index']);

            $router->get('business/{businessId}/addresses', [AddressController::class, 'index']);

            $router->get('business/{businessId}/opening-hours', [OpeningHoursController::class, 'index']);

            $router->get('business/{businessId}/images', [BusinessImageController::class, 'index']);

            $router->get('business/{businessId}/reviews', [ReviewsController::class, 'index']);

            $router->get('business/{businessId}/ratings', [ReviewsController::class, 'ratings']);

            $router->get('businesses', [BusinessController::class, 'index']);
        });

Route::prefix('api/business')
    ->middleware(['auth:api', 'role'])
    ->group(
        function (Router $router) {
            $router->post('{businessId}/contacts/{contactId}/phones', [PhoneController::class, 'store']);
            $router->get('{businessId}/contacts/{contactId}/phones/{id}', [PhoneController::class, 'show']);
            $router->put('{businessId}/contacts/{contactId}/phones/{id}', [PhoneController::class, 'update']);
            $router->delete('{businessId}/contacts/{contactId}/phones/{id}', [PhoneController::class, 'destroy']);

            $router->post('{businessId}/contacts', [ContactsController::class, 'store']);
            $router->get('{businessId}/contacts/{id}', [ContactsController::class, 'show']);
            $router->put('{businessId}/contacts/{id}', [ContactsController::class, 'update']);
            $router->delete('{businessId}/contacts/{id}', [ContactsController::class, 'destroy']);

            $router->post('{businessId}/addresses', [AddressController::class, 'store']);
            $router->get('{businessId}/addresses/{id}', [AddressController::class, 'show']);
            $router->put('{businessId}/addresses/{id}', [AddressController::class, 'update']);
            $router->delete('{businessId}/addresses/{id}', [AddressController::class, 'destroy']);

            $router->post('{businessId}/opening-hours', [OpeningHoursController::class, 'store']);
            $router->get('{businessId}/opening-hours/{id}', [OpeningHoursController::class, 'show']);
            $router->put('{businessId}/opening-hours/{id}', [OpeningHoursController::class, 'update']);
            $router->delete('{businessId}/opening-hours/{id}', [OpeningHoursController::class, 'destroy']);

            $router->post('{businessId}/images', [BusinessImageController::class, 'store']);
            $router->get('{businessId}/images/{id}', [BusinessImageController::class, 'show']);
            $router->put('{businessId}/images/{id}', [BusinessImageController::class, 'update']);
            $router->delete('{businessId}/images/{id}', [BusinessImageController::class, 'destroy']);

            $router->post('{businessId}/reviews', [ReviewsController::class, 'store']);
            $router->get('{businessId}/reviews/{id}', [ReviewsController::class, 'show']);
            $router->put('{businessId}/reviews/{id}', [ReviewsController::class, 'update']);
            $router->delete('{businessId}/reviews/{id}', [ReviewsController::class, 'destroy']);
        });

Route::prefix('api/users')
    ->middleware(['auth:api', 'role'])
    ->group(function (Router $router) {
        $router->get('', [UserController::class, 'index']);
        $router->get('{id}', [UserController::class, 'show']);
        $router->put('{id}', [UserController::class, 'update']);
        $router->delete('{id}', [UserController::class, 'destroy']);

        $router->get('{userId}/user-images', [UserImageController::class, 'index']);
        $router->post('{userId}/user-images', [UserImageController::class, 'store']);
        $router->get('{userId}/user-images/{id}', [UserImageController::class, 'show']);
        $router->put('{userId}/user-images/{id}', [UserImageController::class, 'update']);
        $router->delete('{userId}/user-images/{id}', [UserImageController::class, 'destroy']);

        $router->get('{userId}/business', [UserBusinessController::class, 'index']);
        $router->post('{userId}/business', [UserBusinessController::class, 'store']);
        $router->get('{userId}/business/{id}', [UserBusinessController::class, 'show']);
        $router->put('{userId}/business/{id}', [UserBusinessController::class, 'update']);
        $router->delete('{userId}/business/{id}', [UserBusinessController::class, 'destroy']);
    });

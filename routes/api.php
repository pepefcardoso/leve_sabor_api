<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\BusinessImageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\CookingStyleController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OpeningHoursController;
use App\Http\Controllers\PhoneController;
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

Route::group([],
    function (Router $router) {
        $router->post('register', [UserController::class, 'store']);
        $router->post('login', [UserController::class, 'login']);
    });

Route::middleware(['auth:api', 'role'])->group(
    function (Router $router) {

        $router->get('users', [UserController::class, 'index']);
        $router->get('users/{id}', [UserController::class, 'show']);
        $router->put('users/{id}', [UserController::class, 'update']);
        $router->delete('users/{id}', [UserController::class, 'destroy']);

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

        $router->get('contacts/{contactId}/phones', [PhoneController::class, 'index']);
        $router->post('contacts/{contactId}/phones', [PhoneController::class, 'store']);
        $router->get('contacts/{contactId}/phones/{id}', [PhoneController::class, 'show']);
        $router->put('contacts/{contactId}/phones/{id}', [PhoneController::class, 'update']);
        $router->delete('contacts/{contactId}/phones/{id}', [PhoneController::class, 'destroy']);

        $router->get('cooking-styles', [CookingStyleController::class, 'index']);
        $router->post('cooking-styles', [CookingStyleController::class, 'store']);
        $router->get('cooking-styles/{id}', [CookingStyleController::class, 'show']);
        $router->put('cooking-styles/{id}', [CookingStyleController::class, 'update']);
        $router->delete('cooking-styles/{id}', [CookingStyleController::class, 'destroy']);

        $router->get('businesses/{businessId}/contacts', [ContactsController::class, 'index']);
        $router->post('businesses/{businessId}/contacts', [ContactsController::class, 'store']);
        $router->get('businesses/{businessId}/contacts/{id}', [ContactsController::class, 'show']);
        $router->put('businesses/{businessId}/contacts/{id}', [ContactsController::class, 'update']);
        $router->delete('businesses/{businessId}/contacts/{id}', [ContactsController::class, 'destroy']);

        $router->get('businesses/{businessId}/addresses', [AddressController::class, 'index']);
        $router->post('businesses/{businessId}/addresses', [AddressController::class, 'store']);
        $router->get('businesses/{businessId}/addresses/{id}', [AddressController::class, 'show']);
        $router->put('businesses/{businessId}/addresses/{id}', [AddressController::class, 'update']);
        $router->delete('businesses/{businessId}/addresses/{id}', [AddressController::class, 'destroy']);

        $router->get('roles', [RoleController::class, 'index']);
        $router->post('roles', [RoleController::class, 'store']);
        $router->get('roles/{id}', [RoleController::class, 'show']);
        $router->put('roles/{id}', [RoleController::class, 'update']);
        $router->delete('roles/{id}', [RoleController::class, 'destroy']);

        $router->get('businesses/{businessId}/opening-hours', [OpeningHoursController::class, 'index']);
        $router->post('businesses/{businessId}/opening-hours', [OpeningHoursController::class, 'store']);
        $router->get('businesses/{businessId}/opening-hours/{id}', [OpeningHoursController::class, 'show']);
        $router->put('businesses/{businessId}/opening-hours/{id}', [OpeningHoursController::class, 'update']);
        $router->delete('businesses/{businessId}/opening-hours/{id}', [OpeningHoursController::class, 'destroy']);

        $router->get('users/{userId}/user-images', [UserImageController::class, 'index']);
        $router->post('users/{userId}/user-images', [UserImageController::class, 'store']);
        $router->get('users/{userId}/user-images/{id}', [UserImageController::class, 'show']);
        $router->put('users/{userId}/user-images/{id}', [UserImageController::class, 'update']);
        $router->delete('users/{userId}/user-images/{id}', [UserImageController::class, 'destroy']);

        $router->get('users/{userId}/business', [UserBusinessController::class, 'index']);
        $router->post('users/{userId}/business', [UserBusinessController::class, 'store']);
        $router->get('users/{userId}/business/{id}', [UserBusinessController::class, 'show']);
        $router->put('users/{userId}/business/{id}', [UserBusinessController::class, 'update']);
        $router->delete('users/{userId}/business/{id}', [UserBusinessController::class, 'destroy']);

        $router->get('businesses/{businessId}/images', [BusinessImageController::class, 'index']);
        $router->post('businesses/{businessId}/images', [BusinessImageController::class, 'store']);
        $router->get('businesses/{businessId}/images/{id}', [BusinessImageController::class, 'show']);
        $router->put('businesses/{businessId}/images/{id}', [BusinessImageController::class, 'update']);
        $router->delete('businesses/{businessId}/images/{id}', [BusinessImageController::class, 'destroy']);
    });

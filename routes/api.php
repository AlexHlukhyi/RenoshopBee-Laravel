<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::get('categories', 'CategoryController@getCategories');

Route::get('categories/{id}/products', 'ProductController@getProductsByCategoryId');

Route::get('products/{id}', 'ProductController@getProductById');

Route::get('products', 'ProductController@getPopularProducts');

Route::get('search', 'ProductController@getProductsByName');

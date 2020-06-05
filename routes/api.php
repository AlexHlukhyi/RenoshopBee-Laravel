<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('categories', 'CategoryController@getCategories');

Route::get('categories/{id}/products', 'ProductController@getProductsByCategoryId');

Route::get('products/{id}', 'ProductController@getProductById');

Route::get('products', 'ProductController@getPopularProducts');

Route::get('search', 'ProductController@getProductsByName');

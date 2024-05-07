<?php

use Illuminate\Support\Facades\Route;
// link the PostController file
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

// Define a route wherein a view to create a post will be returned to the user
// "::" - scope resolution operator, it is used to access static methods, static properties, and constats of a class without needing to create an instance of that class
Route::get('/posts/create', [PostController::class, 'create']);

// Define a route wherein form data will be sent via POST method to the /posts URI endpoint
Route::post('/posts', [PostController::class, 'store']);

// Define a route that will return a view containing all posts
Route::get('/posts', [PostController::class, 'index']);

// Define a route that will return a view for the welcome page
Route::get('/', [PostController::class, 'welcome']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

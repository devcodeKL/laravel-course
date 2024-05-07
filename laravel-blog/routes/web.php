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

// Define a route that will return a view containing only the authenticated user's posts
Route::get('/myPosts', [PostController::class, 'myPosts']);

// Define a route wherein a view showing a specific post with matching URL parameter ID will be returned to the user
// Route parameters or wildcard are always enclosed within a curly braces and should consists of alphabetic characeters. Route parameters are injected into route callbacks/controllers based on their order.
Route::get('/posts/{id}', [PostController::class, 'show']);

// Define a route that will return an edit form for a specific Post when a GET request is received at the /posts/{id}/edit endpoint.
Route::get('/posts/{id}/edit', [PostController::class, 'edit']);

// Define a route that will overwrite an existing post with matching URL parameter ID via PUT method
Route::put('/posts/{id}', [PostController::class, 'update']);

// Define a route that will delete a post of the matching URL parameter ID
// Route::delete('/posts/{id}', [PostController::class, 'destroy']);

// Activity Solution
Route::delete('/posts/{id}',[PostController::class,'archive']);

// Define a route that will call this like action when a PUT request is received at the /posts/{id}/like endpoint
Route::put('/posts/{id}/like', [PostController::class, 'like']);

// Define a route that will call the comment action when a POST request is received at the /posts/{id}/comment endpoint
Route::post('/posts/{id}/comment', [PostController::class, 'comment']);

// Define a route that will enable users to delete comments in posts
Route::delete('/posts/{id}/{commentId}/delete', [PostController::class, 'deleteComment']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

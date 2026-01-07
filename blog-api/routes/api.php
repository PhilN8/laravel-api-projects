<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('posts', PostController::class);
Route::apiResource('categories', CategoryController::class);

Route::get('/authors/{author}/posts', function (User $author) {
    return PostResource::collection(
        resource: $author->posts()->with('category')->latest()->paginate(10)
    );
});

Route::get('/categories/{category}/posts', function (Category $category) {
    return PostResource::collection(
        resource: $category->posts()->with('author')->latest()->paginate(10)
    );
});

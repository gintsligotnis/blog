<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|----------------------------------------------F----------------------------
|
| Here is where you can register web routes for your applicatioFn. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [BlogController::class, 'index'])->name('index');
Route::get('/create', [BlogController::class, 'createPost'])->name('blog.create');
Route::post('/create', [BlogController::class, 'handleCreatePost'])->name('blog.handleCreate');
Route::get('/view/{slug}', [BlogController::class, 'viewSinglePost'])->name('blog.view');
Route::get('/edit/{slug}', [BlogController::class, 'editPost'])->name('blog.edit');
Route::post('/edit/{slug}', [BlogController::class, 'handelEditPost'])->name('blog.handelEdit');
Route::get('/delete/{slug}', [BlogController::class, 'deletePost'])->name('blog.delete');
Route::post('/delete/{slug}', [BlogController::class, 'handleDeletePost'])->name('blog.handleDelete');
Route::get('/like/{slug}', [BlogController::class, 'addPostLike'])->name('blog.like');
Route::get('/like/{slug}', [BlogController::class, 'removePostLike'])->name('blog.unlike');

Route::get('/api/posts', [ApiController::class, 'getLatest'])->name('api.posts');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Database\Factories\CategoryFactory;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

//Principal
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/all', [HomeController::class, 'all'])->name('home.all');

//Articulos
Route::resource('articles', ArticleController::class)
                ->except('show')
                ->names('articles');
//Categorias
Route::resource('categories', CategoryFactory::class)
                ->except('show')
                ->names('categories');

//Comentarios
Route::resource('comments', CommentController::class)
            ->only('index', 'destroy')
            ->names('comments');

//Ver articulos
Route::get('article/{article}', [ArticleController::class, 'show'])->name('articles.show');

//Ver articulos por categorias
Route::get('category/{category}', [CategoryController::class, 'detail'])->name('category.detail');

//Guardar comentarios
Route::get('/comment', [CommentController::class, 'store'])->name('comments.store');

Auth::routes();

/*
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');

Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
*/
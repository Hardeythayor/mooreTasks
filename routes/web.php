<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('is_admin')->prefix('tasks')->name('tasks.')->group(function () {
    Route::get('/', [TasksController::class, 'index'])->name('index')->withoutMiddleware('is_admin');
    Route::get('/admin', [TasksController::class, 'tasks_for_admin_index'])->name('admin');
    Route::post('/admin/fetch', [TasksController::class, 'fetch_tasks_for_admin'])->name('admin.fetch');
    Route::get('/admin/fetch/{id}', [TasksController::class, 'edit'])->name('edit');
    Route::post('/create', [TasksController::class, 'store'])->name('create');
    Route::put('/update/{id}', [TasksController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [TasksController::class, 'destroy'])->name('delete');
});

Route::middleware('is_admin')->prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'users_index'])->name('index');
    Route::post('/fetch', [UserController::class, 'index'])->name('fetch');
    Route::put('/change_status/{id}', [UserController::class, 'update'])->name('change_status');
});


<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\ToDoController;
use App\Http\Controllers\ToDoWeeklyController;
use App\Http\Controllers\UserController;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
| Lembrete: Route::post('url da página', 'nome da função no controller')->name('nome da route')
|
*/


Route::get('', function () {
    return view('index')->with('nav', '');
});


Route::prefix('login')->controller(UserController::class)->group(function () {
    Route::get('', 'index')->name('login');
    Route::post('store', 'store')->name('login.store');
    Route::post('authenticate', 'authenticate')->name('login.authenticate');
    Route::middleware('auth')->get('logout', 'logout')->name('login.logout');

    Route::get('reset-password/{}', 'reset_password')->name('login.reset-password'); // unfinished route due to smtp email
    Route::post('forget-password', 'forget_password')->name('login.forget-password'); // unfinished route due to smtp email
});


Route::middleware('auth')->group(function () {
    Route::prefix('to-do')->controller(ToDoController::class)->group(function () {
        Route::get('', 'index')->name('to-do.index');
        Route::get('show', 'show')->name('to-do.show');
        Route::get('edit/{id}', 'edit')->name('to-do.edit');
        Route::post('store', 'store')->name('to-do.store');
        Route::post('update', 'update')->name('to-do.update');
        Route::post('destroy', 'destroy')->name('to-do.destroy');
    });

    Route::prefix('task')->controller(TaskController::class)->group(function () {
        Route::get('show', 'show')->name('task.show');
        Route::get('edit/{id}', 'edit')->name('task.edit');
        Route::post('store', 'store')->name('task.store');
        Route::post('update', 'update')->name('task.update');

        Route::post('weekly/destroy', [App\Http\Controllers\ToDoWeeklyController::class, 'destroy'])->name('task.weekly.destroy');
    });
});

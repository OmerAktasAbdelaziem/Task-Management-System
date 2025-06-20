<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('index') : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get   ('/profile', [UsersController::class, 'edit'   ])->name('profile.edit');
    Route::patch ('/profile', [UsersController::class, 'update' ])->name('profile.update');
    Route::delete('/profile', [UsersController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/', [HomeController::class, 'index'])->name('home.index');


// PROJECTS ROUTES
Route::prefix('projects')->group(function (){
    Route::post('insert',      [ProjectsController::class, 'insert'])->name('projects.insert');
    Route::post('update/{id}', [ProjectsController::class, 'update'])->name('projects.update');
    Route::get ('delete/{id}', [ProjectsController::class, 'delete'])->name('projects.delete');
});

// TASKS ROUTES
Route::prefix('tasks')->group(function (){
    Route::post('insert',                  [TasksController::class, 'insert'          ])->name('tasks.insert');
    Route::post('update/{id}',             [TasksController::class, 'update'          ])->name('tasks.update');
    Route::get ('delete/{id}',             [TasksController::class, 'delete'          ])->name('tasks.delete');
    Route::post('toggle-completion/{id?}', [TasksController::class, 'toggleCompletion'])->name('tasks.toggleCompletion');
    Route::get ('filter',                  [TasksController::class, 'filter'          ])->name('tasks.filter');
    Route::post('update-priority',         [TasksController::class, 'updatePriority'  ])->name('tasks.updatePriority');
});

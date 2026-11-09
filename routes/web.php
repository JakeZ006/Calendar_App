<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::inertia('/', 'UserRegister')->name('landing');
    Route::inertia('/register', 'UserRegister')->name('register');
    Route::post('/register', [UserController::class, 'store'])->name('register.store');

    Route::inertia('/login', 'UserLogin')->middleware('guest')->name('login');
    Route::post('/login', [UserController::class, 'loginUser'])->name('login.store');
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [UserController::class, 'logoutUser'])->name('logout');

    Route::inertia('/editUser', 'EditUser')->name('user.edit');
    Route::post('/updateUser', [UserController::class, 'updateUser'])->name('user.update');
    Route::inertia('/deleteUser', 'DeleteUser')->name('user.delete');
    Route::post('/deleteUser', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

    Route::get('/home', [NoteController::class, 'index'])->name('home');

    Route::post('/createNote', [NoteController::class, 'store'])->name('note.store');
    Route::patch('/updateNote/{note}', [NoteController::class, 'update'])->name('note.update');
    Route::delete('/deleteNote/{note}', [NoteController::class, 'destroy'])->name('note.destroy');

    Route::post('/uploadImage', [ImageController::class, 'store'])->name('image.store');
    Route::delete('/deleteImage', [ImageController::class, 'destroy'])->name('image.destroy');

});

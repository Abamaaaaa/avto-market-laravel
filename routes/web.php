<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Публичные страницы
Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/category/{id}', [PostController::class, 'category'])->name('category');

// Авторизация и регистрация
Route::get('/login', [PostController::class, 'loginView'])->name('login');
Route::post('/login', [PostController::class, 'login']);
Route::get('/register', [PostController::class, 'registerView'])->name('register');
Route::post('/register', [PostController::class, 'register']);
Route::post('/logout', [PostController::class, 'logout'])->name('logout');

// Панель журналиста
Route::get('/journalist', [PostController::class, 'journalistView'])->name('journalist');
Route::post('/journalist', [PostController::class, 'storeText'])->name('text.store');

// Админ-панель
Route::get('/admin', [PostController::class, 'adminView'])->name('admin');
Route::delete('/admin/text/{id}', [PostController::class, 'deleteText'])->name('text.delete');
Route::post('/admin/user/{id}/role', [PostController::class, 'changeRole'])->name('user.role');
// Календарь ТО
Route::get('/calendar', [PostController::class, 'calendarView'])->name('calendar');
Route::post('/calendar', [PostController::class, 'storeCalendar'])->name('calendar.store');

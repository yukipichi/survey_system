<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;

Route::get('/', [FrontController::class, 'index'])->name('front.index');

Route::post('/back-to-index', [FrontController::class, 'backToIndex'])->name('front.backToIndex');

Route::post('/confirm', [FrontController::class, 'confirm'])->name('front.confirm');

Route::post('/store', [FrontController::class, 'store'])->name('front.store');

Route::get('/system', [LoginController::class, 'showLoginForm']); // ログインフォーム表示
Route::post('/system/login', [LoginController::class, 'login'])->name('auth.login'); // ログイン処理
Route::post('/system', [LogoutController::class, 'logout'])->name('auth.logout'); // ログアウト処理

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('auth.register'); //ユーザー登録画面表示
Route::post('/register', [RegisterController::class, 'create'])->name('auth.create'); //ユーザー登録処理

Route::get('/system/answer/index', [AnswerController::class, 'index'])->name('auth.answer'); //アンケートフォーム表示
Route::get('/system/answers/{id} ', [AnswerController::class, 'show'])->name('auth.details'); //アンケートの詳細表示

Route::post('/system/answers/destroy/{id}', [AnswerController::class, 'destroy'])->name('auth.destroy'); //アンケート削除機能
Route::post('/system/answer/delete-multiple', [AnswerController::class, 'deleteMultiple'])->name('auth.deleteMultiple');//複数削除機能

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\front\FrontController;
use App\Http\Controllers\system\LoginController;
use App\Http\Controllers\system\AnswerController;
use App\Http\Controllers\system\LogoutController;
use App\Http\Controllers\system\RegisterController;

// フロント画面用ルーティング
Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::post('/back-to-index', [FrontController::class, 'backToIndex'])->name('front.backToIndex');
Route::post('/confirm', [FrontController::class, 'confirm'])->name('front.confirm');
Route::post('/store', [FrontController::class, 'store'])->name('front.store');

// 管理画面用ルーティング
Route::get('/system/login', [LoginController::class, 'showLoginForm'])->name('system.auth.showLoginForm'); //管理画面ログイン処理
Route::post('/system/login', [LoginController::class, 'login'])->name('system.auth.login'); // 管理画面ログイン処理
Route::post('/system/logout', [LogoutController::class, 'logout'])->name('system.auth.logout'); // 管理画面ログアウト処理
Route::get('/system/register', [RegisterController::class, 'showRegisterForm'])->name('system.auth.register'); //管理画面ユーザー登録画面表示
Route::post('/system/register', [RegisterController::class, 'create'])->name('system.auth.create'); //管理画面ユーザー登録処理

// 認証機能
Route::middleware('auth')->group(function () {
    Route::get('/system/answers', [AnswerController::class, 'index'])->name('system.answer.index'); //管理画面アンケート一覧
    Route::get('/system/answers/{id} ', [AnswerController::class, 'show'])->name('system.answer.details'); //管理画面アンケートの詳細
    Route::post('/system/answers/destroy/{id}', [AnswerController::class, 'destroy'])->name('system.answer.destroy'); //管理画面アンケート削除
    Route::post('/system/answers/deleteSelected', [AnswerController::class, 'deleteSelected']);
    Route::post('/system/answers/fetchList', [AnswerController::class, 'fetchList'])->name('system.answer.fetchList');// アンケート一覧の表示
});


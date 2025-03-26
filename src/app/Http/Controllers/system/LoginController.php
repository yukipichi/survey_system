<?php

namespace App\Http\Controllers\system;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLoginForm(Request $request)
    {
        return view('system.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //ログイン状態の保持
        $remember = $request->has('remember');

        //もしログインが成功したらanswerのページにリダイレクトする
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember)) {
            return redirect()->route('system.answer.index');
        }

        //エラーならログインページに戻す
        return redirect()->route('system.auth.login')
            ->withErrors(['login' => 'メールアドレスまたはパスワードが間違っています。'])
            ->withInput($request->only('email'));
    }
}

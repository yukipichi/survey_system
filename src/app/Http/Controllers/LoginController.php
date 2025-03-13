<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //もしログインが成功したらanswerのページにリダイレクトする
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return redirect()->route('auth.answer');
        }
        //エラーならログインページに戻す
        return redirect()->back()
            ->withErrors(['login' => 'メールアドレスまたはパスワードが間違っています。'])
            ->withInput($request->only('email'));
    }
}

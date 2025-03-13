<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\ConfirmRequest;

class FrontController extends Controller
{
    public function index()
    {
        $ages = DB::table('ages')->orderBy('sort', 'asc')->get();
        return view('front.index', ['ages' => $ages]);
    }

    public function backToIndex(Request $request)
    {
        return redirect()->route('front.index')->withInput();
    }

    public function confirm(ConfirmRequest $request)
    {
        $validatedData = $request->validated();

        $gender = '';
        if ($validatedData['gender'] == 1) {
            $gender = '男性';
        } elseif ($validatedData['gender'] == 2) {
            $gender = '女性';
        } else {
            $gender = '不明';
        }

        $age_id = '';
        if ($validatedData['age_id'] == 1) {
            $age_id = '10代以下';
        } elseif ($validatedData['age_id'] == 2) {
            $age_id = '20代';
        } elseif ($validatedData['age_id'] == 3) {
            $age_id = '30代';
        } elseif ($validatedData['age_id'] == 4) {
            $age_id = '40代';
        } elseif ($validatedData['age_id'] == 5) {
            $age_id = '50代';
        } elseif ($validatedData['age_id'] == 6) {
            $age_id = '60代';
        } else {
            $age_id = '不明';
        }

        $is_send_email = '';
        if ($validatedData['is_send_email'] == '1') {
            $is_send_email = '送信可能';
        } else {
            $is_send_email = '送信不可';
        }

        $fullname = $validatedData['fullname'];
        $email = $validatedData['email'];
        $feedback = $validatedData['feedback'];

        return view('front.confirm', compact('validatedData', 'fullname', 'gender', 'age_id', 'email', 'is_send_email', 'feedback'));
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();

        $gender = '';
        if ($validatedData['gender'] == 1) {
            $gender = '1';
        } elseif ($validatedData['gender'] == 2) {
            $gender = '2';
        }

        $age_id = '';
        if ($validatedData['age_id'] == 1) {
            $age_id = '1';
        } elseif ($validatedData['age_id'] == 2) {
            $age_id = '2';
        } elseif ($validatedData['age_id'] == 3) {
            $age_id = '3';
        } elseif ($validatedData['age_id'] == 4) {
            $age_id = '4';
        } elseif ($validatedData['age_id'] == 5) {
            $age_id = '5';
        } elseif ($validatedData['age_id'] == 6) {
            $age_id = '6';
        }

        $is_send_email = '';
        if ($validatedData['is_send_email'] == '1') {
            $is_send_email = '1';
        } else {
            $is_send_email = '0';
        }

        DB::table('answers')->insert([
            'fullname' => $validatedData['fullname'],
            'gender' => $gender,
            'age_id' => $age_id,
            'email' => $validatedData['email'],
            'feedback' => $validatedData['feedback'],
            'is_send_email' => $is_send_email,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('front.index')->with('success', 'アンケートを送信しました');
    }
}

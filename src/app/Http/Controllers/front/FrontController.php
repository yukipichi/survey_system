<?php

namespace App\Http\Controllers\front;

use App\Models\Answer;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Front\StoreRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ConfirmRequest;

class FrontController extends Controller
{
    public function index()
    {
        $ages = DB::table('ages')->orderBy('sort', 'asc')->get();
        return view('front.index', ['ages' => $ages]);
    }

    public function backToIndex()
    {
        return redirect()->route('front.index')->withInput();
    }

    public function confirm(ConfirmRequest $request)
    {
        $validatedData = $request->validated();

        // 性別と年齢とemail送信ラベルを取得
        $genderLabel = Answer::getGenderLabel($validatedData['gender']);
        $ageLabel = Answer::getAgeLabel($validatedData['age_id']);
        $isSendEmailLabel = Answer::getIsSendEmailLabel($validatedData['is_send_email']);

        return view('front.confirm', compact('validatedData',  'genderLabel', 'ageLabel',  'isSendEmailLabel',));
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();

        // DBにデータを保存
        Answer::create([
            'fullname' => $validatedData['fullname'],
            'gender' => (int)$validatedData['gender'],
            'age_id' => (int)$validatedData['age_id'],
            'email' => $validatedData['email'],
            'feedback' => $validatedData['feedback'],
            'is_send_email' => $validatedData['is_send_email'],
        ]);

        return redirect()->route('front.index')->with('success', 'アンケートを送信しました');
    }
}

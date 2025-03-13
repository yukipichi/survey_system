<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfirmRequest;
use App\Http\Requests\StoreRequest;
use App\Models\Age;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index()
    {
        $ages = Age::orderBy('sort', 'asc')->get();
        return view('front.index', ['ages' => $ages]);
    }

    public function backToIndex(Request $request)
    {
        return redirect()->route('front.index')->withInput();
    }

    public function confirm(ConfirmRequest $request)
    {
        $validatedData = $request->validated();

        // 性別と年齢ラベルを取得
        $genderLabel = Answer::getGenderLabel($validatedData['gender']);
        $ageLabel = Answer::getAgeLabel($validatedData['age_id']);
        $isSendEmailLabel = Answer::getIsSendEmailLabel($validatedData['is_send_email']);

        return view('front.confirm', compact('validatedData', 'genderLabel', 'ageLabel', 'isSendEmailLabel',));
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();

        $isSendEmail = Answer::getIsSendEmailStatus($validatedData['is_send_email']);

        // DBにデータを保存
        Answer::create([
            'fullname' => $validatedData['fullname'],
            'gender' => (int)$validatedData['gender'],
            'age_id' => (int)$validatedData['age_id'],
            'email' => $validatedData['email'],
            'feedback' => $validatedData['feedback'],
            'is_send_email' => $isSendEmail,
        ]);

        return redirect()->route('front.index')->with('success', 'アンケートを送信しました');
    }
}

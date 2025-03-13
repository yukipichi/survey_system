<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function index(Request $request)
    {
        $query = Answer::query();

        // 氏名（LIKE検索）
        if (!empty($request->fullname)) {
            $query->where('fullname', 'LIKE', '%' . $request->fullname . '%');
        }

        if (!empty($request->age_id)) {
            $query->where('age_id', $request->age_id);
        }

        if (!empty($request->gender)) {
            $query->where('gender', $request->gender);
        }
        // 登録日（created_at 範囲検索）
        if (!empty($request->created_from)) {
            $query->whereDate('created_at', '>=', $request->created_from);
        }
        if (!empty($request->created_to)) {
            $query->whereDate('created_at', '<=', $request->created_to);
        }

        // メール送信許可
        if (!empty($request->is_send_email)) {
            $query->where('is_send_email', 1);
        }

        // キーワード検索（feedback & email）
        if (!empty($request->keyword)) {
            $query->where(function ($q) use ($request) {
                $q->where('feedback', 'LIKE', '%' . $request->keyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->keyword . '%');
            });
        }

        $answers = $query->paginate(10);

        foreach ($answers as $answer) {
            if ($answer->gender == 1) {
                $answer->gender = '男性';
            } elseif ($answer->gender == 2) {
                $answer->gender = '女性';
            } else {
                $answer->gender = '不明';
            }
        }

        foreach ($answers as $answer) {
            if ($answer->age_id == 1) {
                $answer->age_id = '10代以下';
            } elseif ($answer->age_id == 2) {
                $answer->age_id = '20代';
            } elseif ($answer->age_id == 3) {
                $answer->age_id = '30代';
            } elseif ($answer->age_id == 4) {
                $answer->age_id = '40代';
            } elseif ($answer->age_id == 5) {
                $answer->age_id = '50代';
            } elseif ($answer->age_id == 6) {
                $answer->age_id = '60代';
            } else {
                $answer->age_id = '不明';
            }
        }

        return view('auth.answer', compact('answers'));
    }

    //詳細表示
    public function show($id)
    {
        $answer = Answer::findOrFail($id);

        return view('auth.details', compact('answer'));
    }

    //削除処理
    public function destroy($id)
    {
        $answer = Answer::find($id);
        $answer->delete();

        return redirect()->route('auth.answer')->with('success', '削除しました');
    }

    //選択削除処理
    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('answer', []);

        if (!is_array($ids) || empty($ids)) {
            return redirect()->back()->with('error', '削除するアンケートが選択されていません');
        }

        Answer::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', '選択されたアンケートを削除しました');
    }
}

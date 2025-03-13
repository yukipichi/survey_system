<?php

namespace App\Http\Controllers\system;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnswerController extends Controller
{
    public function index(Request $request)
    {
        $answers = Answer::query()
            ->fullname($request->fullname)
            ->ageId($request->age_id)
            ->gender($request->gender)
            ->createdFrom($request->created_from)
            ->createdTo($request->created_to)
            ->isSendEmail($request->is_send_email)
            ->keyword($request->keyword)
            ->paginate(10);

        // 各ラベルを追加
        foreach ($answers as $answer) {
            $answer->gender_label = Answer::getGenderLabel($answer->gender);
            $answer->age_label = Answer::getAgeLabel($answer->age_id);
            $answer->feedback_limit = Str::limit($answer->feedback, 30, '...');
        }

        return view('system.answer.index', compact('answers'));
    }

    public function show($id)
    {
        $answer = Answer::findOrFail($id);

        return view('system.answer.details', compact('answer'));
    }

    public function destroy($id)
    {
        $answer = Answer::find($id);
        $answer->delete();

        return redirect()->route('system.answer.destroy')->with('success', '削除しました');
    }

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

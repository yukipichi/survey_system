<?php

namespace App\Http\Controllers\system;

use App\Models\Answer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnswerController extends Controller
{
    public function index(Request $request)
    {
       $answers =Answer::query()
         ->fullname($request->fullname)
         ->ageId($request->age_id)
         ->gender($request->gender)
         ->createdFrom($request->created_from)
         ->createdTo($request->created_to)
         ->isSendEmail($request->is_send_email)
         ->keyword($request->keyword)
         ->paginate(10)
         ->appends(request()->query());

    //各ラベルを追加
    foreach($answers as $answer){
        $answer->gender_label = Answer::getGenderLabel($answer->gender);
        $answer->age_label = Answer::getAgeLabel($answer->age_id);
        $answer->isSendEmail_label = Answer::getIsSendEmailLabel($answer->is_send_email);
        $answer->feedback_limit = Str::limit($answer->feedback, 30, '...');
    }

        return view('system.answer.index', compact('answers'));
    }

    //詳細表示
    public function show($id)
    {
        $answer = Answer::findOrFail($id);

        $genderLabel = Answer::getGenderLabel($answer->gender);
        $ageLabel = Answer::getAgeLabel($answer->age_id);
        $isSendEmailLabel = Answer::getIsSendEmailLabel($answer->is_send_email);

        return view('system.answer.details', compact('answer','genderLabel','ageLabel','isSendEmailLabel'));
    }

    //削除処理
    public function destroy($id)
    {
        $answer = Answer::find($id);
        $answer->delete();

        return redirect()->route('system.answer.index')->with('success', '削除しました');
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

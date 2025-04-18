<?php

namespace App\Http\Controllers\system;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AnswerService;

class AnswerController extends Controller
{

    protected $answerService;

    public function __construct(AnswerService $answerService)
    {
        $this->answerService = $answerService;
    }
    // アンケート画面表示
    public function index()
    {
        return view('system.answer.index');
    }

    // アンケート検索機能
    public function fetchList(Request $request)
    {
        return response()->json(
            $this->answerService->getPaginatedAnswers($request)
        );
    }

    // 詳細表示
    public function show($id)
    {
        $data = $this->answerService->getAnswerDetails($id);

        return view('system.answer.details', $data);
    }

    // 削除処理
    public function destroy($id)
    {
        $this->answerService->deleteAnswer($id);

        return redirect()->route('system.answer.index')->with('success', '削除しました');
    }

    // 選択削除処理
    public function deleteSelected(Request $request)
    {
        $result = $this->answerService->deleteAnswerByIds($request->input('ids'));

        return response()->json($result);
    }
}

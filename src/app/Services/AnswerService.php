<?php

namespace App\Services;

use App\Models\Answer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\AnswerRepository;

class AnswerService
{
    protected $answerRepository;

    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    public function getPaginatedAnswers(Request $request)
    {
        $limit = $request->input('limit', 10); // 1ページの件数
        $offset = $request->input('offset', 0); // 何件目から
        $page = floor($offset / $limit) + 1; // Laravel用の現在ページ番号（1始まり）

        $query = $this->answerRepository->queryWithFilters($request->all());

        // データを取得
        $answers = $query->orderBy(
            $request->input('sort', 'id'),
            $request->input('order', 'asc')
        )->paginate($limit, ['*'], 'page', $page);

        // 各ラベルを追加
        foreach ($answers as $answer) {
            $answer->gender_label = Answer::getGenderLabel($answer->gender);
            $answer->age_label = Answer::getAgeLabel($answer->age_id);
            $answer->isSendEmail_label = Answer::getIsSendEmailLabel($answer->is_send_email);
            $answer->feedback_limit = Str::limit($answer->feedback, 30, '...');
        }

        return $answers;
    }

    public function getAnswerDetails($id)
    {
        $answer = $this->answerRepository->find($id);

        return [
            'answer' => $answer,
            'genderLabel' => Answer::getGenderLabel($answer->gender),
            'ageLabel' => Answer::getAgeLabel($answer->age_id),
            'isSendEmailLabel' => Answer::getIsSendEmailLabel($answer->is_send_email),
        ];
    }

    public function deleteAnswer($id)
    {
        return $this->answerRepository->delete($id);
    }

    public function deleteAnswerByIds(array $ids)
    {
        if (empty($ids)) {
            return ['success' => false, 'message' => 'IDが不正です。'];
        }

        try {
            $deleted = $this->answerRepository->deleteMultiple($ids);

            return [
                'success' => $deleted,
                'message' => $deleted ? null : '削除対象が存在しませんでした。'
            ];
        } catch (\Exception $e) {
            Log::error('選択削除中にエラー発生', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => '削除時にエラーが発生しました。'];
        }
    }
}

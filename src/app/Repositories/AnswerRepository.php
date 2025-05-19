<?php

namespace App\Repositories;

use App\Models\Answer;

class AnswerRepository
{

    public function paginateWithFilters($filters, $limit, $page)
    {
        return Answer::query()
            ->fullname($filters['fullname'] ?? null)
            ->ageId($filters['age_id'] ?? null)
            ->gender($filters['gender'] ?? null)
            ->createdFrom($filters['created_from'] ?? null)
            ->createdTo($filters['created_to'] ?? null)
            ->isSendEmail($filters['is_send_email'] ?? null)
            ->keyword($filters['keyword'] ?? null)
            ->orderBy('id', 'asc')
            ->paginate($limit, ['*'], 'page', $page);
    }

    public function find($id)
    {
        return Answer::findOrFail($id);
    }

    public function delete($id)
    {
        return Answer::destroy($id);
    }

    public function deleteMultiple(array $ids)
    {
        return Answer::whereIn('id', $ids)->delete();
    }
}

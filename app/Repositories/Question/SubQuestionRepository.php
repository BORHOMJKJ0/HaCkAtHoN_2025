<?php

namespace App\Repositories\Question;

use App\Models\Question\MainQuestion;
use App\Models\Question\SubQuestion;
use App\Traits\Lockable;

class SubQuestionRepository
{
    use Lockable;

    public function create(MainQuestion $mainQuestion, array $data)
    {
        return $this->lockForCreate(function () use ($data, $mainQuestion) {
            $data['main_question_id'] = $mainQuestion->id;
            return SubQuestion::create($data);
        });
    }

    public function retrieveById(SubQuestion $mainQuestion)
    {
        return $this->lockAndRetrieve(SubQuestion::class, $mainQuestion->id);
    }

    public function retrieveByMainQuestionId(MainQuestion $mainQuestion)
    {
        return $mainQuestion->subQuestions;
    }

    public function update(SubQuestion $subQuestion, array $data)
    {
        return $this->lockForUpdate(SubQuestion::class, $subQuestion->id, function ($lockedQuestion) use ($data) {
            $lockedQuestion->update($data);

            return $lockedQuestion;
        });
    }

    public function delete(SubQuestion $subQuestion)
    {
        return $this->lockForDelete(SubQuestion::class, $subQuestion->id, function ($lockedQuestion) {
            return $lockedQuestion->delete();
        });
    }
}

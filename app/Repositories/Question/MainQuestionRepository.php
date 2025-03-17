<?php

namespace App\Repositories\Question;

use App\Models\Chat\Chat;
use App\Models\Question\MainQuestion;
use App\Traits\Lockable;

class MainQuestionRepository
{
    use Lockable;

    public function create(Chat $chat, array $data)
    {
        return $this->lockForCreate(function () use ($data, $chat) {
            $data['chat_id'] = $chat->id;
            return MainQuestion::create($data);
        });
    }

    public function retrieveById(MainQuestion $mainQuestion)
    {
        return $this->lockAndRetrieve(MainQuestion::class, $mainQuestion->id);
    }

    public function retrieveByChatId(Chat $chat)
    {
        return $chat->mainQuestions;
    }

    public function update(MainQuestion $mainQuestion, array $data)
    {
        return $this->lockForUpdate(MainQuestion::class, $mainQuestion->id, function ($lockedQuestion) use ($data) {
            $lockedQuestion->update($data);

            return $lockedQuestion;
        });
    }

    public function delete(MainQuestion $mainQuestion)
    {
        return $this->lockForDelete(MainQuestion::class, $mainQuestion->id, function ($lockedQuestion) {
            return $lockedQuestion->delete();
        });
    }
}

<?php

namespace App\Repositories\Chat;

use App\Models\Chat\Chat;
use App\Traits\Lockable;

class ChatRepository
{
    use Lockable;

    public function getAll($items)
    {
        return Chat::where('user_id', auth()->id())->orderBy('created_at', 'desc')->paginate($items);
    }

    public function create(array $data)
    {
        return $this->lockForCreate(function () use ($data) {
            return Chat::create($data);
        });
    }

    public function update(Chat $chat, array $data)
    {
        return $this->lockForUpdate(Chat::class, $chat->id, function ($lockedChat) use ($data) {
            $lockedChat->update($data);

            return $lockedChat;
        });
    }

    public function delete(Chat $chat)
    {
        return $this->lockForDelete(Chat::class, $chat->id, function ($lockedChat) {
            return $lockedChat->delete();
        });
    }
}

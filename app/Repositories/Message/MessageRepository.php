<?php

namespace App\Repositories\Message;

use App\Models\Message\Message;
use App\Traits\Lockable;

class MessageRepository
{
    use Lockable;

    public function create(array $data)
    {
        return $this->lockForCreate(function () use ($data) {
            return Message::create($data);
        });
    }

    public function update(Message $message, array $data)
    {
        return $this->lockForUpdate(Message::class, $message->id, function ($lockedMessage) use ($data) {
            $lockedMessage->update($data);

            return $lockedMessage;
        });
    }

    public function delete(Message $message)
    {
        return $this->lockForDelete(Message::class, $message->id, function ($lockedMessage) {
            return $lockedMessage->delete();
        });
    }
}

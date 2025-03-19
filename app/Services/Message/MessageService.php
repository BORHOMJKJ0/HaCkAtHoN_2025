<?php

namespace App\Services\Message;

use App\Helpers\ResponseHelper;
use App\Http\Resources\Message\MessageResource;
use App\Models\Chat\Chat;
use App\Models\Message\Message;
use App\Repositories\Message\MessageRepository;
use App\Traits\AuthTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class MessageService
{
    use AuthTrait;

    protected $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function addMessage(array $data)
    {
        $this->validateMessageData($data);
        $this->checkOwnership(Chat::find($data['chat_id']), 'Chat Message', 'create');
        $message = $this->messageRepository->create($data);
        $data = [
            'Message' => MessageResource::make($message),
        ];

        return ResponseHelper::jsonResponse($data, 'Message created successfully.', 201);
    }

    public function updateMessage(Message $message, array $data)
    {
        $this->checkOwnership($message->chat, 'Message', 'update');
        $this->validateMessageData($data, 'sometimes');
        if (isset($data['chat_id'])) {
            $this->checkOwnership(Chat::find($data['chat_id']), 'Chat Message', 'create');
        }
        $message = $this->messageRepository->update($message, $data);
        $data = [
            'Message' => MessageResource::make($message),
        ];

        return ResponseHelper::jsonResponse($data, 'Message created successfully.', 201);
    }

    public function deleteMessage(Message $message)
    {
        $this->checkOwnership($message->chat, 'Message', 'delete');
        $this->messageRepository->delete($message);

        return ResponseHelper::jsonResponse([], 'Message deleted successfully.');
    }

    protected function validateMessageData(array $data, $rule = 'required'): void
    {
        $allowedAttributes = ['message', 'is_ai', 'chat_id', 'type_id'];

        $unexpectedAttributes = array_diff(array_keys($data), $allowedAttributes);
        if (! empty($unexpectedAttributes)) {
            throw new HttpResponseException(
                ResponseHelper::jsonResponse(
                    [],
                    'You are not allowed to send the following attributes: '.implode(', ', $unexpectedAttributes),
                    400,
                    false
                )
            );
        }
        $validator = Validator::make($data, [
            'message' => "$rule|string",
            'is_ai' => "$rule",
            'chat_id' => "$rule|exists:chats,id",
            'type_id' => "$rule|exists:types,id",
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            throw new HttpResponseException(
                ResponseHelper::jsonResponse(
                    [],
                    $errors,
                    400,
                    false
                )
            );
        }
    }
}

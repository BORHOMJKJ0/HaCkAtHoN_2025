<?php

namespace App\Services\Chat;

use App\Helpers\ResponseHelper;
use App\Http\Resources\Chat\ChatResource;
use App\Models\Chat\Chat;
use App\Repositories\Chat\chatRepository;
use App\Traits\AuthTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatService
{
    use AuthTrait;

    protected chatRepository $chatRepository;

    public function __construct(chatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    public function getAllChats(Request $request)
    {
        $items = $request->query('items', 20);
        $chats = $this->chatRepository->getAll($items);

        $data = [
            'Chats' => ChatResource::collection($chats),
            'total_pages' => $chats->lastPage(),
            'current_page' => $chats->currentPage(),
            'hasMorePages' => $chats->hasMorePages(),
        ];

        return ResponseHelper::jsonResponse($data, 'Chats retrieved successfully');
    }

    public function getChatById(Chat $chat)
    {
        $this->checkOwnership($chat, 'Chat', 'perform');
        $data = ['Chat' => ChatResource::make($chat)];

        return ResponseHelper::jsonResponse($data, 'Chat retrieved successfully!');
    }

    public function createChat(array $data): JsonResponse
    {
        try {
            $this->validateChatData($data);
            $data['user_id'] = auth()->id();
            $chat = $this->chatRepository->create($data);
            $data = [
                'Chat' => ChatResource::make($chat),
            ];

            $response = ResponseHelper::jsonResponse($data, 'Chat created successfully!', 201);
        } catch (HttpResponseException $e) {
            $response = $e->getResponse();
        }

        return $response;
    }

    public function updateChat(Chat $chat, array $data)
    {
        try {
            $this->checkOwnership($chat, 'Chat', 'update');
            $this->validateChatData($data, 'sometimes');
            $chat = $this->chatRepository->update($chat, $data);
            $data = [
                'Chat' => ChatResource::make($chat),
            ];
            $response = ResponseHelper::jsonResponse($data, 'Chat updated successfully!');
        } catch (HttpResponseException $e) {
            $response = $e->getResponse();
        }

        return $response;
    }

    public function deleteChat(Chat $chat)
    {
        try {
            $this->checkOwnership($chat, 'Chat', 'delete');
            $this->chatRepository->delete($chat);
            $response = ResponseHelper::jsonResponse([], 'Chat deleted successfully!');
        } catch (HttpResponseException $e) {
            $response = $e->getResponse();
        }

        return $response;
    }

    protected function validateChatData(array $data, $rule = 'required'): void
    {
        $allowedAttributes = ['address', 'name'];

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
            'name' => "$rule|string|unique:chats,name",
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

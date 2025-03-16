<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Chat\Chat;
use App\Services\Chat\ChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function index(Request $request): JsonResponse
    {
        return $this->chatService->getAllChats($request);
    }

    public function show(Chat $chat): JsonResponse
    {
        return $this->chatService->getChatById($chat);
    }

    public function store(Request $request): JsonResponse
    {
        return $this->chatService->createChat($request->all());
    }

    public function update(Request $request, Chat $chat): JsonResponse
    {
        return $this->chatService->updateChat($chat, $request->all());
    }

    public function destroy(Chat $chat): JsonResponse
    {
        return $this->chatService->deleteChat($chat);
    }
}

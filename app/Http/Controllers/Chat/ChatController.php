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

 /**
  * @OA\SecurityScheme(
  *     securityScheme="bearerAuth",
  *     type="http",
  *     scheme="bearer",
  *     bearerFormat="JWT",
  *     description="Enter JWT Bearer token in the format 'Bearer {token}'"
  * )
  */
    /**
     * @OA\Get(
     *     path="/chats",
     *     summary="Retrieve user chats",
     *     tags={"Chats"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Page number for pagination",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="items",
     *         in="query",
     *         required=false,
     *         description="Number of items per page",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Chats retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Chats retrieved successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="Chats", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=11),
     *                         @OA\Property(property="address", type="string", example="University"),
     *                         @OA\Property(property="guest_name", type="string", example="Baraa"),
     *                         @OA\Property(property="created_at", type="string", example="2 seconds ago")
     *                     )
     *                 ),
     *                 @OA\Property(property="total_pages", type="integer", example=1),
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="hasMorePages", type="boolean", example=false)
     *             ),
     *             @OA\Property(property="status_code", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated"),
     *             @OA\Property(property="status_code", type="integer", example=401)
     *         )
     *     )
     * )
     */

    public function index(Request $request): JsonResponse
    {
        return $this->chatService->getAllChats($request);
    }
    /**
     * @OA\Get(
     *     path="/chats/{id}",
     *     summary="Retrieve a specific chat by ID",
     *     tags={"Chats"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Chat ID to retrieve",
     *         @OA\Schema(type="integer", example=11)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Chat retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Chat retrieved successfully!"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="Chat", type="object",
     *                     @OA\Property(property="id", type="integer", example=11),
     *                     @OA\Property(property="address", type="string", example="University"),
     *                     @OA\Property(property="guest_name", type="string", example="Baraa"),
     *                     @OA\Property(property="created_at", type="string", example="2 minutes ago")
     *                 )
     *             ),
     *             @OA\Property(property="status_code", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated"),
     *             @OA\Property(property="status_code", type="integer", example=401)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Chat not found"),
     *             @OA\Property(property="status_code", type="integer", example=404)
     *         )
     *     )
     * )
     */

    public function show(Chat $chat): JsonResponse
    {
        return $this->chatService->getChatById($chat);
    }
    /**
     * @OA\Post(
     *     path="/chats",
     *     summary="Create a new chat",
     *     tags={"Chats"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Provide chat details",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"address", "guest_name"},
     *                 @OA\Property(property="address", type="string", example="University"),
     *                 @OA\Property(property="guest_name", type="string", example="Baraa")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Chat created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Chat created successfully!"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="Chat", type="object",
     *                     @OA\Property(property="id", type="integer", example=11),
     *                     @OA\Property(property="address", type="string", example="University"),
     *                     @OA\Property(property="guest_name", type="string", example="Baraa"),
     *                     @OA\Property(property="created_at", type="string", example="1 second ago")
     *                 )
     *             ),
     *             @OA\Property(property="status_code", type="integer", example=201)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated"),
     *             @OA\Property(property="status_code", type="integer", example=401)
     *         )
     *     )
     * )
     */

    public function store(Request $request): JsonResponse
    {
        return $this->chatService->createChat($request->all());
    }
    /**
     * @OA\Put(
     *     path="/chats/{id}",
     *     summary="Update an existing chat",
     *     tags={"Chats"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Chat ID to update",
     *         @OA\Schema(type="integer", example=11)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Provide updated chat details",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(property="address", type="string", example="University"),
     *                 @OA\Property(property="guest_name", type="string", example="Baraa")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Chat updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Chat updated successfully!"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="Chat", type="object",
     *                     @OA\Property(property="id", type="integer", example=11),
     *                     @OA\Property(property="address", type="string", example="University"),
     *                     @OA\Property(property="guest_name", type="string", example="Baraa"),
     *                     @OA\Property(property="created_at", type="string", example="1 minute ago")
     *                 )
     *             ),
     *             @OA\Property(property="status_code", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated"),
     *             @OA\Property(property="status_code", type="integer", example=401)
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden - User is not authorized to update the chat",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="You are not authorized to update this Chat. This Chat isn't for you"),
     *             @OA\Property(property="status_code", type="integer", example=403)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Chat not found"),
     *             @OA\Property(property="status_code", type="integer", example=404)
     *         )
     *     )
     * )
     */

    public function update(Request $request, Chat $chat): JsonResponse
    {
        return $this->chatService->updateChat($chat, $request->all());
    }
    /**
     * @OA\Delete(
     *     path="/chats/{id}",
     *     summary="Delete an existing chat",
     *     tags={"Chats"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Chat ID to delete",
     *         @OA\Schema(type="integer", example=11)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Chat deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Chat deleted successfully!"),
     *             @OA\Property(property="status_code", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated"),
     *             @OA\Property(property="status_code", type="integer", example=401)
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden - User is not authorized to delete the chat",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="You are not authorized to delete this Chat. This Chat isn't for you"),
     *             @OA\Property(property="status_code", type="integer", example=403)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Chat Not Found"),
     *             @OA\Property(property="status_code", type="integer", example=404)
     *         )
     *     )
     * )
     */

    public function destroy(Chat $chat): JsonResponse
    {
        return $this->chatService->deleteChat($chat);
    }
}

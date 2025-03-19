<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Models\Chat\Chat;
use App\Models\Message\Message;
use App\Services\Message\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
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
     * @OA\Post(
     *     path="/messages/",
     *     summary="Add a new message to a chat",
     *     tags={"Messages"},
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Message data",
     *
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *
     *             @OA\Schema(
     *                 required={"message", "is_ai", "chat_id", "type_id"},
     *
     *                 @OA\Property(property="message", type="string", example="What is your name?"),
     *                 @OA\Property(property="is_ai", type="inteager", example=0),
     *                 @OA\Property(property="chat_id", type="integer", example=1),
     *                 @OA\Property(property="type_id", type="integer", example=1)
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Message created successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="successful", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Message created successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="Message", type="object",
     *                     @OA\Property(property="id", type="integer", example=15),
     *                     @OA\Property(property="message", type="string", example="Hello Ouama"),
     *                     @OA\Property(property="is_ai", type="boolean", example=true),
     *                     @OA\Property(property="type", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="type", type="string", example="career")
     *                     ),
     *                     @OA\Property(property="created_at", type="string", example="1 second ago")
     *                 )
     *             ),
     *             @OA\Property(property="status_code", type="integer", example=201)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Invalid chat ID or type ID",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The selected chat id is invalid."),
     *             @OA\Property(property="status_code", type="integer", example=400)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized to create message",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="You are not authorized to create this Chat Message . This Chat Message isn't for you"),
     *             @OA\Property(property="status_code", type="integer", example=403)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated"),
     *             @OA\Property(property="status_code", type="integer", example=401)
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        return $this->messageService->addMessage($request->all());
    }

    /**
     * @OA\Put(
     *     path="/messages/{id}",
     *     summary="Update an existing message",
     *     tags={"Messages"},
     *     security={{"bearerAuth": {}}},

     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the message to update",
     *
     *         @OA\Schema(type="integer", example=15)
     *     ),

     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Message data to update",
     *
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *
     *             @OA\Schema(
     *                 required={"message"},
     *
     *                 @OA\Property(property="message", type="string", example="Updated message content")
     *             )
     *         )
     *     ),

     *
     *     @OA\Response(
     *         response=200,
     *         description="Message updated successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="successful", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Message updated successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="Message", type="object",
     *                     @OA\Property(property="id", type="integer", example=15),
     *                     @OA\Property(property="message", type="string", example="Updated message content"),
     *                     @OA\Property(property="is_ai", type="boolean", example=true),
     *                     @OA\Property(property="type", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="type", type="string", example="career")
     *                     ),
     *                     @OA\Property(property="created_at", type="string", example="1 minute ago")
     *                 )
     *             ),
     *             @OA\Property(property="status_code", type="integer", example=200)
     *         )
     *     ),

     *
     *    @OA\Response(
     *          response=404,
     *          description="Message not found",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="successful", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Message not found"),
     *              @OA\Property(property="status_code", type="integer", example=404)
     *          )
     *      ),
     *
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized to update message",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="You are not authorized to update this message."),
     *             @OA\Property(property="status_code", type="integer", example=403)
     *         )
     *     ),

     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated"),
     *             @OA\Property(property="status_code", type="integer", example=401)
     *         )
     *     )
     * )
     */
    public function update(Message $message, Request $request)
    {
        return $this->messageService->updateMessage($message, $request->all());
    }

    /**
     * @OA\Delete(
     *     path="/messages/{id}",
     *     summary="Delete a message",
     *     tags={"Messages"},
     *     security={{"bearerAuth": {}}},

     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the message to delete",
     *
     *         @OA\Schema(type="integer", example=15)
     *     ),

     *
     *     @OA\Response(
     *         response=200,
     *         description="Message deleted successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="successful", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Message deleted successfully"),
     *             @OA\Property(property="status_code", type="integer", example=200)
     *         )
     *     ),

     *
     *     @OA\Response(
     *         response=404,
     *         description="Message not found",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Message not found"),
     *             @OA\Property(property="status_code", type="integer", example=404)
     *         )
     *     ),

     *
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized to delete message",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="You are not authorized to delete this message."),
     *             @OA\Property(property="status_code", type="integer", example=403)
     *         )
     *     ),

     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated"),
     *             @OA\Property(property="status_code", type="integer", example=401)
     *         )
     *     )
     * )
     */
    public function destroy(Message $message)
    {
        return $this->messageService->deleteMessage($message);
    }
}

<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Chat\Chat;
use App\Models\Question\MainQuestion;
use App\Services\Question\MainQuestionService;
use Illuminate\Http\Request;

class MainQuestionController extends Controller
{
    protected $mainQuestionService;
    public function __construct(MainQuestionService $mainQuestionService)
    {
        $this->mainQuestionService = $mainQuestionService;
    }

    /**
     * @OA\Get(
     *     path="/questions/main/{chat}",
     *     summary="Get questions by chat ID",
     *     tags={"Questions"},
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="chat",
     *         in="path",
     *         description="ID of the chat",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Questions retrieved successfully",
     *
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Questions retrieved successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="questions", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="text", type="string", example="How much is your wealth?")
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="status_code", type="integer", example=200)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated"),
     *             @OA\Property(property="status_code", type="integer", example=401)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Chat not found",
     *
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Chat not found"),
     *             @OA\Property(property="status_code", type="integer", example=404)
     *         )
     *     )
     * )
     */
    public function getQuestionsByChatId(Chat $chat)
    {
        return $this->mainQuestionService->getQuestionsByChatId($chat);
    }

    /**
     * @OA\Post(
     *     path="/questions/main/{chat}",
     *     summary="Add a new question to a chat",
     *     tags={"Questions"},
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="chat",
     *         in="path",
     *         description="ID of the chat",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Question data",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"text", "type_id"},
     *                 @OA\Property(
     *                     property="text",
     *                     type="string",
     *                     example="What is your name?"
     *                 ),
     *                 @OA\Property(
     *                     property="type_id",
     *                     type="integer",
     *                     example=1
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Question created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Question created successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="question", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="text", type="string", example="How much is your wealth?"),
     *                     @OA\Property(property="type", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="type", type="string", example="General")
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="status_code", type="integer", example=201)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated"),
     *             @OA\Property(property="status_code", type="integer", example=401)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Chat or Type not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Chat or Type not found"),
     *             @OA\Property(property="status_code", type="integer", example=404)
     *         )
     *     )
     * )
     */
    public function addQuestion(Chat $chat, Request $request)
    {
        return $this->mainQuestionService->addQuestion($chat, $request);
    }

    /**
     * @OA\Delete(
     *     path="/questions/main/{mainQuestion}",
     *     summary="Delete a main question",
     *     tags={"Questions"},
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="mainQuestion",
     *         in="path",
     *         description="ID of the main question to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Question deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Question deleted successfully"),
     *             @OA\Property(property="data", type="object", example={}),
     *             @OA\Property(property="status_code", type="integer", example=200)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated"),
     *             @OA\Property(property="status_code", type="integer", example=401)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Question not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Question not found"),
     *             @OA\Property(property="status_code", type="integer", example=404)
     *         )
     *     )
     * )
     */
    public function deleteQuestion(MainQuestion $mainQuestion)
    {
        return $this->mainQuestionService->deleteQuestion($mainQuestion);
    }
}

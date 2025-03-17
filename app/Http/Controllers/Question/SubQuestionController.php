<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question\MainQuestion;
use App\Models\Question\SubQuestion;
use App\Services\Question\SubQuestionService;
use Illuminate\Http\Request;

class SubQuestionController extends Controller
{
    protected $subQuestionService;
    public function __construct(SubQuestionService $subQuestionService)
    {
        $this->subQuestionService = $subQuestionService;
    }

    /**
     * @OA\Get(
     *     path="/questions/sub/{mainQuestion}",
     *     summary="Get sub-questions by main question ID",
     *     tags={"Questions"},
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="mainQuestion",
     *         in="path",
     *         description="ID of the main question",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Questions retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Questions retrieved successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="questions", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="text", type="string", example="What is your favorite color?")
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
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated"),
     *             @OA\Property(property="status_code", type="integer", example=401)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Main question not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Main question not found"),
     *             @OA\Property(property="status_code", type="integer", example=404)
     *         )
     *     )
     * )
     */
    public function getQuestionsByMainQuestionId(MainQuestion $mainQuestion)
    {
        return $this->subQuestionService->getQuestionsByMainQuestionId($mainQuestion);
    }

    /**
     * @OA\Post(
     *     path="/questions/sub/{mainQuestion}",
     *     summary="Add a new sub-question to a main question",
     *     tags={"Questions"},
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="mainQuestion",
     *         in="path",
     *         description="ID of the main question",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Sub-question data",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"text"},
     *                 @OA\Property(
     *                     property="text",
     *                     type="string",
     *                     example="What is your favorite color?"
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Sub-question created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Question created successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="question", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="text", type="string", example="What is your favorite color?")
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
     *         description="Main question not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Main question not found"),
     *             @OA\Property(property="status_code", type="integer", example=404)
     *         )
     *     )
     * )
     */
    public function addQuestion(MainQuestion $mainQuestion, Request $request)
    {
        return $this->subQuestionService->addQuestion($mainQuestion, $request);
    }

    /**
     * @OA\Delete(
     *     path="/questions/sub/{subQuestion}",
     *     summary="Delete a sub-question",
     *     tags={"Questions"},
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="subQuestion",
     *         in="path",
     *         description="ID of the sub-question to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Sub-question deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Sub-question deleted successfully"),
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
     *         description="Sub-question not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="successful", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Sub-question not found"),
     *             @OA\Property(property="status_code", type="integer", example=404)
     *         )
     *     )
     * )
     */
    public function deleteQuestion(SubQuestion $subQuestion)
    {
        return $this->subQuestionService->deleteQuestion($subQuestion);
    }
}

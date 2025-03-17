<?php

namespace App\Services\Question;

use App\Helpers\ResponseHelper;
use App\Http\Resources\Question\MainQuestionResource;
use App\Models\Chat\Chat;
use App\Models\Question\MainQuestion;
use App\Repositories\Question\MainQuestionRepository;
use Illuminate\Http\Request;

class MainQuestionService
{
    protected $mainQuestionRepository;

    public function __construct(MainQuestionRepository $mainQuestionRepository)
    {
        $this->mainQuestionRepository = $mainQuestionRepository;
    }

    public function getQuestionsByChatId(Chat $chat)
    {
        $questions = $this->mainQuestionRepository->retrieveByChatId($chat);
        $data = [
            'questions' => MainQuestionResource::collection($questions),
        ];
        return ResponseHelper::jsonResponse($data, 'Questions retrieved successfully.');
    }

    public function addQuestion(Chat $chat, Request $request)
    {
        $data = $request->all();
        $question = $this->mainQuestionRepository->create($chat, $data);
        $data = [
            'question' => MainQuestionResource::make($question),
        ];
        return ResponseHelper::jsonResponse($data, 'Question created successfully.', 201);
    }

    public function deleteQuestion(MainQuestion $mainQuestion)
    {
        $this->mainQuestionRepository->delete($mainQuestion);
        return ResponseHelper::jsonResponse([], 'Question deleted successfully.');
    }
}

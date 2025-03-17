<?php

namespace App\Services\Question;

use App\Helpers\ResponseHelper;
use App\Http\Resources\Question\SubQuestionResource;
use App\Models\Question\MainQuestion;
use App\Models\Question\SubQuestion;
use App\Repositories\Question\SubQuestionRepository;
use Illuminate\Http\Request;

class SubQuestionService
{
    protected $subQuestionRepository;

    public function __construct(SubQuestionRepository $subQuestionRepository)
    {
        $this->subQuestionRepository = $subQuestionRepository;
    }

    public function getQuestionsByMainQuestionId(MainQuestion $mainQuestion)
    {
        $questions = $this->subQuestionRepository->retrieveByMainQuestionId($mainQuestion);
        $data = [
            'questions' => SubQuestionResource::collection($questions)
        ];
        return ResponseHelper::jsonResponse($data, 'Questions retrieved successfully.');
    }

    public function addQuestion(MainQuestion $mainQuestion, Request $request)
    {
        $data = $request->all();
        $question = $this->subQuestionRepository->create($mainQuestion, $data);
        $data = [
            'question' => SubQuestionResource::make($question),
        ];
        return ResponseHelper::jsonResponse($data, 'Question created successfully.', 201);
    }

    public function deleteQuestion(SubQuestion $subQuestion)
    {
        $this->subQuestionRepository->delete($subQuestion);
        return ResponseHelper::jsonResponse([], 'Question deleted successfully.');
    }
}

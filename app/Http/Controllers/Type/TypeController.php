<?php

namespace App\Http\Controllers\Type;

use App\Http\Controllers\Controller;
use App\Models\Type\Type;
use App\Services\Type\TypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    protected $typeService;

    public function __construct(TypeService $typeService)
    {
        $this->typeService = $typeService;
    }

    public function index(Request $request): JsonResponse
    {
        return $this->typeService->getAllTypes($request);
    }

    public function show(Type $type): JsonResponse
    {
        return $this->typeService->getTypeById($type);
    }
}

<?php

namespace App\Services\Type;

use App\Helpers\ResponseHelper;
use App\Http\Resources\Type\TypeResource;
use App\Models\Type\Type;
use App\Repositories\Type\TypeRepository;
use Illuminate\Http\Request;

class TypeService
{
    protected TypeRepository $typeRepository;

    public function __construct(TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    public function getAllTypes(Request $request)
    {
        $items = $request->query('items', 20);
        $types = $this->typeRepository->getAll($items);

        $data = [
            'Types' => TypeResource::collection($types),
            'total_pages' => $types->lastPage(),
            'current_page' => $types->currentPage(),
            'hasMorePages' => $types->hasMorePages(),
        ];

        return ResponseHelper::jsonResponse($data, 'Types retrieved successfully');
    }

    public function getTypeById(Type $type)
    {
        $data = ['Type' => TypeResource::make($type)];

        return ResponseHelper::jsonResponse($data, 'Type retrieved successfully!');
    }
}

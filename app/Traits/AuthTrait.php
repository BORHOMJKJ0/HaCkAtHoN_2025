<?php

namespace App\Traits;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Exceptions\HttpResponseException;

trait AuthTrait
{
    public function checkOwnership($model, $modelType, $action)
    {
        $user = auth()->user();
        if ($model && $model->user_id !== $user->id) {
            throw new HttpResponseException(
                ResponseHelper::jsonResponse([],
                    "You are not authorized to {$action} this {$modelType} . This {$modelType} isn't for you",
                    403, false)
            );
        }
    }
}

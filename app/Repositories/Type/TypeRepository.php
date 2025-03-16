<?php

namespace App\Repositories\Type;

use App\Models\Type\Type;

class TypeRepository
{
    public function getAll($items)
    {
        return Type::orderBy('type', 'asc')->paginate($items);
    }
}

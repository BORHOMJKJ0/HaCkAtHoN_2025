<?php

namespace App\Models\Question;

use App\Models\Chat\Chat;
use App\Models\Type\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function subQuestions()
    {
        return $this->hasMany(SubQuestion::class);
    }
}

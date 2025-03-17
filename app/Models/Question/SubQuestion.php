<?php

namespace App\Models\Question;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function mainQuestion()
    {
        $this->belongsTo(MainQuestion::class);
    }
}

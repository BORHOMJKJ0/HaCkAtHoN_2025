<?php

namespace App\Models\Message;

use App\Models\Chat\Chat;
use App\Models\Type\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_ai' => 'boolean',
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}

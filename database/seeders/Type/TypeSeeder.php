<?php

namespace Database\Seeders\Type;

use App\Models\Type\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $types = [
                'Personal', 'Technical', 'Business', 'Entertainment', 'Health & Wellness',
                'Science', 'Sports', 'Education', 'Finance', 'History',
                'Philosophy', 'Psychology', 'Technology', 'Politics', 'Music',
                'Travel', 'Food & Cooking', 'Art & Culture', 'Lifestyle', 'Self-Improvement',
            ];

            foreach ($types as $type) {
                Type::create(['type' => $type]);
            }
        });
    }
}

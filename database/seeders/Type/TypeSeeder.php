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
                'career', 'scientific', 'subjectivity',
            ];

            foreach ($types as $type) {
                Type::create(['type' => $type]);
            }
        });
    }
}

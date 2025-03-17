<?php

namespace Database\Seeders\Question;

use App\Models\Question\SubQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            SubQuestion::factory(10)->create();
        });
    }
}

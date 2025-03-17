<?php

namespace Database\Seeders\Question;

use App\Models\Question\MainQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MainQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            MainQuestion::factory(10)->create();
        });
    }
}

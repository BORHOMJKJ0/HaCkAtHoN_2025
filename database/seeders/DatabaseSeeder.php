<?php

namespace Database\Seeders;

use Database\Seeders\Chat\ChatSeeder;
use Database\Seeders\Question\MainQuestionSeeder;
use Database\Seeders\Question\SubQuestionSeeder;
use Database\Seeders\Type\TypeSeeder;
use Database\Seeders\User\UserSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $this->call([
                UserSeeder::class,
                ChatSeeder::class,
                TypeSeeder::class,
                MainQuestionSeeder::class,
                SubQuestionSeeder::class,
            ]);
        });
    }
}

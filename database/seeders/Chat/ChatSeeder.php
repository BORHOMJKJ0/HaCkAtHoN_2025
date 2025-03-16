<?php

namespace Database\Seeders\Chat;

use App\Models\Chat\Chat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            Chat::factory(10)->create();
        });
    }
}

<?php

namespace Database\Seeders\Message;

use App\Models\Message\Message;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            Message::factory(10)->create();
        });
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\Quiz;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        factory(Quiz::class, 1)->create();
        factory(\App\Models\Question::class, 2)->create();
    }
}

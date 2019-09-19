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
        factory(Quiz::class, 1)->create();
        factory(\App\Models\Question::class, 2)->create();

        \App\User::create([
            'name' => 'David Sitrick',
            'email' => 'sitrick2@gmail.com',
            'email_verified_at' => \Carbon\Carbon::now(),
            'password' => bcrypt('TEST1234'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}

<?php

use App\User;
use App\Blog;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // factory(App\Blog::class, 15)->create();
        factory(App\User::class, 15)->create()->each(function ($user) {
            factory(App\Blog::class, random_int(2, 5))->create(['user_id' => $user]);
        });
    }
}

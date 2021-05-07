<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'blog_id' => factory(Blog::class),
        'name' => $this->faker->name,
        'body' => $this->faker->realText(20),
    ];
});

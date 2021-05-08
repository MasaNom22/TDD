<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Blog;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'title' => $this->faker->realText(20),
        'body' => $this->faker->realText(100),
        'status' => Blog::OPEN,
    ];
});

// $factory->state(Blog::class, 'seeding', [
//     'status' => $this->faker->biasedNumberBetween(0,1, ['\Faker\Provider\Biased', 'linearHigh'])
// ]);

//ステータスがCLOSED ->status('closed')で使用可能
$factory->state(Blog::class, 'closed', [
    'status' => Blog::CLOSED,
]);





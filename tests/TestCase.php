<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function login(User $user = null)
    {
        $user = $user ?? factory(User::class)->create();

        $this->actingAs($user);

        return $user;
    }
}

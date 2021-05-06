<?php

namespace Tests\Unit;

use App\User;
use App\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;
    function testUserRelation ()
    {
        $blog = factory(Blog::class)->create();

        $this->assertInstanceOf(User::class, $blog->user);
    }
}

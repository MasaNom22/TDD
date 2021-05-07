<?php

namespace Tests\Unit;

use App\User;
use App\Blog;
use Illuminate\Support\Collection;
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

    function testCommentsRelation ()
    {
        $this->withoutexceptionhandling();
        $blog = factory(Blog::class)->create();

        $this->assertInstanceOf(Collection::class, $blog->comments);
    }
}

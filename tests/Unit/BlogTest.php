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

      /**@test scopeOnlyOpen */
    function ブログの公開非公開のスコープ ()
    {
        $blog = factory(Blog::class)->state('closed')->create([
            // 'status' => 'Blog::CLOSED',
            'title' => 'あいうえお']);
        $blog1 = factory(Blog::class)->create(['title' => 'ブログB']);
        
        $blogs = Blog::onlyOpen()->get();
        
        $this->assertFalse($blogs->contains($blog));
        $this->assertTrue($blogs->contains($blog1));

    }

    //MODELはmakeでも良い (データベースに保存しない)
    /**@test isCLOSED */
    function ブログの公開時はTrue非公開はFalse ()
    {
        $blog = factory(Blog::class)->make();
        $blog1 = factory(Blog::class)->state('closed')->make();
        
        $this->assertFalse($blog->isClosed());
        $this->assertTrue($blogs->isClosed());

    }
}

<?php

namespace Tests\Feature\Controllers;

use App\User;
use App\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogViewControllerTest extends TestCase
{
    use RefreshDatabase;
    /** @test index */
    function testブログのトップページを開ける()
    {
        
        // $this->withoutExceptionHandling();
        $blog = factory(Blog::class)->create();
        $response = $this->get('/');

        $response->assertViewIs('index')
                ->assertOK()
                ->assertSee($blog->title)
                ->assertSee($blog->user->name);

        //factory(Blog::class)->create(['title' => 'あいうえお']);

    }

    function testブログのトップページを開ける2()
    {
        
        // $this->withoutExceptionHandling();
        factory(Blog::class)->create(['title' => 'あいうえお']);
        $response = $this->get('/');

        $response->assertOK()
                ->assertSee('あいうえお');

        //factory(Blog::class)->create(['title' => 'あいうえお']);

    }

    function test非公開のものは表示されない()
    {
        $blog = factory(Blog::class)->create([
            'status' => 'Blog::CLOSED',
            'title' => 'あいうえお']);
        $blog1 = factory(Blog::class)->create(['title' => 'ブログB']);
        $response = $this->get('/');

        $response->assertViewIs('index')
                ->assertOK()
                ->assertDontSee('あいうえお')
                ->assertSee('ブログB');
    }
    /**@test scopeOnlyOpen */
    function ブログの公開非公開のスコープ ()
    {
        $blog = factory(Blog::class)->create([
            'status' => 'Blog::CLOSED',
            'title' => 'あいうえお']);
        $blog1 = factory(Blog::class)->create(['title' => 'ブログB']);
        
        $blogs = Blog::onlyOpen()->get();
        
        $this->assertFalse($blogs->contains($blog));
        $this->assertTrue($blogs->contains($blog1));

    }
    
    
}

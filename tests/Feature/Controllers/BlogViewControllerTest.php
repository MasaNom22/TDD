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
    
}

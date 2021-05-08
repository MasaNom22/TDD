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
        $blog = factory(Blog::class)->state('closed')->create([
            'title' => 'あいうえお']);
        $blog1 = factory(Blog::class)->create(['title' => 'ブログB']);
        $response = $this->get('/');

        $response->assertViewIs('index')
                ->assertOK()
                ->assertDontSee('あいうえお')
                ->assertSee('ブログB');
    }

    /** @test show */
    function testブログの詳細画面を表示()
    {       
        $blog = factory(Blog::class)->create();
        $response = $this->get(route('blog.show', ['blog' => $blog]))
                ->assertOK()
                ->assertSee($blog->title)
                ->assertSee($blog->user->name);
    }

    /** @test show */
    function test非公開のブログの詳細画面は表示されない()
    {   
        $blog = factory(Blog::class)->state('closed')->create();
        $response = $this->get(route('blog.show', ['blog' => $blog]));

        $response->assertForbidden();
    }
    
    
}

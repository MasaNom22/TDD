<?php

namespace Tests\Feature\Controllers;

use App\User;
use App\Blog;
use App\Comment;
use Carbon\Carbon;
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
    function testブログの詳細画面を表示、コメントが古い順に表示()
    {       
        $blog = factory(Blog::class)->create();
        $comment = factory(Comment::class)->create([
            'created_at' => now()->sub('2 days'),
            'name' => '太郎',
            'blog_id' => $blog->id,
            ]);
        
        $comment1 = factory(Comment::class)->create([
            'created_at' => now()->sub('3 days'),
            'name' => '次郎',
            'blog_id' => $blog->id,
            ]);

        $comment1 = factory(Comment::class)->create([
            'created_at' => now()->sub('1 days'),
            'name' => '三郎',
            'blog_id' => $blog->id,
            ]);
        
        $response = $this->get(route('blog.show', ['blog' => $blog]))
                ->assertOK()
                ->assertSee($blog->title)
                ->assertSee($blog->user->name)
                ->assertSeeInOrder(['次郎','太郎','三郎']);
    }

    /** @test show */
    function test非公開のブログの詳細画面は表示されない()
    {   
        $blog = factory(Blog::class)->state('closed')->create();
        $response = $this->get(route('blog.show', ['blog' => $blog]));

        $response->assertForbidden();
    }

    /** @test show */
    function クリスマスの日以外はメリークリスマスと表示されない()
    {   
        $blog = factory(Blog::class)->create();
        Carbon::setTestNow('2020-12-24');
        $response = $this->get(route('blog.show', ['blog' => $blog]));

        $response->assertOK()
                ->assertDontSee('メリークリスマス');
    }

    /** @test show */
    function クリスマスの日はメリークリスマスと表示される()
    {   
        $blog = factory(Blog::class)->create();
        Carbon::setTestNow('2020-12-25');
        $response = $this->get(route('blog.show', ['blog' => $blog]));

        $response->assertOK()
                ->assertSee('メリークリスマス');
    }
    
    
}

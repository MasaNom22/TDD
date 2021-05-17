<?php

namespace Tests\Feature\Controllers\Mypage;

use App\User;
use App\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class blogMypageControllerTest extends TestCase
{
    use RefreshDatabase;

    function ゲストはブログを管理できない ()
    {
        // 認証していない場合
        $url = 'mypage/login';
        $this->get('mypage/blogs')
            ->assertRedirect($url);
        $this->get('mypage/blogs/create')
            ->assertRedirect($url);
        
    }

    function test認証している場合に限り、マイページ開ける ()
    {
        
        // 認証済みの場合
        // $user = factory(User::class)->create();

        // $this->actingAs($user)->get('mypage/blogs')
        //     ->assertOk();

        $user = $this->login();
        $myblog = factory(Blog::class)->create(['user_id' => $user]);
        $otherblog = factory(Blog::class)->create();
        $this->get('mypage/blogs')
            ->assertOk()
            ->assertDontSee($otherblog->title)
            ->assertSee($myblog->title);
    }

    function testブログの新規登録 ()
    {
        $this->login();
        $this->get('mypage/blogs/create')
        ->assertOK();
    }
}

<?php

namespace Tests\Feature\Controllers\Mypage;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class blogMypageControllerTest extends TestCase
{
    use RefreshDatabase;
    function test認証している場合に限り、マイページ開ける ()
    {
        // 認証していない場合
        $this->get('mypage/blogs')
            ->assertRedirect('mypage/login');
        
        // 認証済みの場合
        // $user = factory(User::class)->create();

        // $this->actingAs($user)->get('mypage/blogs')
        //     ->assertOk();

        $this->login();
        $this->get('mypage/blogs')
            ->assertOk();
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLoginControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testログイン画面を開ける()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    // public function test登録時の入力チェック()
    // {
    //     $this->withoutExceptionHandling();
    //     $url='mypage/login';
    //     $response = $this->from($url)->post($url, []);
    //     ->assertRedirect($url);
        
    //     app()->setlocale('testing');
    //     $this->from('mypage/login')->post($url, ['email' => ''])->assertSessionHasErrors('email');
        
    //     $response->assertStatus(200);
    // }

    public function testログアウトできる()
    {
        $this->login();
        $this->post('mypage/logout')
        ->assertRedirect($url = 'mypage/login');
        $this->get($url)
        ->assertSee('ログアウトしました');
        $this->assertGuest();
    }
}

<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see App\Http\Controllers\SignUpController
 */
class SignUpControllerTest extends TestCase
{
    use RefreshDatabase;
    /** @test index */
    public function ユーザー登録画面を開ける()
    {
        $response = $this->get('signup');

        $response->assertStatus(200);
    }
    //上書きできる
    private function validData($overrides =[])
    {
        return array_merge([
            'name' => '太郎',
            'email' => 'aaa@bbb.net',
            'password' => 'abcd1234',
        ], $overrides);
    }

    /** @test store */
    function ユーザー登録できる() 
    {
        $this->withoutExceptionHandling();
        // $validData = [
        //     'name' => '太郎',
        //     'email' => 'aaa@bbb.net',
        //     'password' => 'abcd1234',
        // ];
        $validData = $this->validData();

        $this->post(route('signup.post', $validData))
            ->assertRedirect('mypage/blogs');

        unset($validData['password']);
        $this->assertDatabaseHas('users', $validData);

        //パスワードの検証
        $user = User::firstWhere($validData);
        $this->assertnotNull($user);

        $this->assertTrue(\Hash::check('abcd1234', $user->password));

        $this->assertAuthenticatedAs($user);
    }
    /** @test store */
    function 不正なデータでは登録できない () 
    {
        // $this->withoutExceptionHandling();
        $url = 'signup';

        // $this->get('signup');

        $this->from('signup')->post($url, [])
            ->assertRedirect('signup');

            $this->post($url, ['name' => ''])->assertSessionHasErrors('name');
            $this->post($url, ['name' => str_repeat('あ', 21)])->assertSessionHasErrors('name');
            $this->post($url, ['name' => str_repeat('あ', 20)])->assertSessionDoesntHaveErrors('name');
            $this->post($url, ['email' => ''])->assertSessionHasErrors('email');
            $this->post($url, ['email' => 'aa@bb@cc'])->assertSessionHasErrors('email');
            $this->post($url, ['email' => 'aa@ああ.いい'])->assertSessionHasErrors('email');

            
            $this->post($url, ['password' => ''])->assertSessionHasErrors('password');
            $this->post($url, ['password' => 'abc'])->assertSessionHasErrors('password');
            $this->post($url, ['password' => 'abcd'])->assertSessionDoesntHaveErrors('password');
    }
}

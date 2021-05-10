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
            ->assertOK();

        unset($validData['password']);
        $this->assertDatabaseHas('users', $validData);

        //パスワードの検証
        $user = User::firstWhere($validData);
        $this->assertnotNull($user);

        $this->assertTrue(\Hash::check('abcd1234', $user->password));
    }
}

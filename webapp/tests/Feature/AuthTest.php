<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    use WithFaker;

    /**
     * ホームページを表示に成功する場合
     *
     * @return void
     */
    public function testHomePage(){
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * ログインサイトを表示に成功する場合
     *
     * @return void
     */
    public function testLoginPage()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * サインアップサイトを表示に成功する場合
     *
     * @return void
     */
    public function testSingupPage()
    {
        $response = $this->get('/signup');
        $response->assertStatus(200);
    }

    /**
     * サインアップに成功する場合
     *
     * @return void
     */
    public function testSignupSuccess(){
        $number = $this->faker->numberBetween(10000000, 99999999);
        $user = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $number,
            'confirm' => $number
        ];
        $this->post('/signup', $user)->assertRedirect('/');
    }

    /**
     * サインアップに失敗する場合
     *
     * @return void
     */
    public function testSignupFaile(){
        $user = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => '12678',
            'confirm' => '1234'
        ];
        $response = $this->post('/signup', $user);
        $response->assertStatus(302);
    }

    public function testLoginSuccess(){
        $number = $this->faker->numberBetween(10000000, 99999999);
        $user = factory(User::class)->create([
            'password' => Hash::make($number)
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $number
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/');
    }

    public function testLoginFaile(){
        $user = [
            'email' => $this->faker->name,
            'password' => $this->faker->numberBetween(10000000, 99999999)
        ];
        $this->post('/login', $user)->assertRedirect('/login');
    }
}

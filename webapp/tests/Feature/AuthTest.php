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
        $user = [
            'name' => 'Nguyen Viet Thai',
            'email' => 'nguyenvietthai1351997@gmail.com',
            'password' => '12345678',
            'confirm' => '12345678'
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
            'name' => 'Nguyen Viet Thai',
            'email' => 'email-invalid',
            'password' => '12678',
            'confirm' => '1234'
        ];
        $response = $this->post('/signup', $user);
        $response->assertStatus(302);
    }

    public function testLoginSuccess(){
        $user = factory(User::class)->create([
            'name' => 'Tony Stark',
            'email' => 'tony.stark@iron.man',
            'password' => Hash::make('ironman123')
        ]);
        
        $response = $this->post('/login', [
            'email' => 'tony.stark@iron.man',
            'password' => 'ironman123'
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/');
    }

    public function testLoginFaile(){
        $user = [
            'email' => 'tony.stark@iron.man',
            'password' => 'peter123@'
        ];
        $this->post('/login', $user)->assertRedirect('/login');
    }
}

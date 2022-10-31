<?php

namespace Tests\Feature\App\Controller\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class LoginControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        $response = $this->get(route('login.admin'));

        $response->assertStatus(200);
        $response->assertSeeText('Sign in');
      
    }

    public function test_postLogin_if_success()
    {
        $this->post(route('login.admin.post'), [
            'email' => 'admin@example.com',
            'password' => '1234567@',
        ])
            ->assertStatus(302)
            ->assertRedirect(route('dashboard'));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_font_login()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSeeText('Sign in');
      
    }

    public function test_font_postLogin_if_success()
    {
        $this->post(route('login.post'), [
            'email' => 'user@example.com',
            'password' => '1234567@',
        ])
            ->assertStatus(302)
            ->assertRedirect(route('home'));
    }

    /**
     * @dataProvider invalidLogin
     */
    public function test_postLogin_if_email_wrong($postData, $invalidFields)
    {
        $this->post(route('login.admin.post'), $postData)
            ->assertSessionHasErrors($invalidFields)
            ->assertStatus(302);
    }

    /**
     * @dataProvider invalidLogin
     */
    public function test_font_postLogin_if_email_wrong($postData, $invalidFields)
    {
        $this->post(route('login.admin.post'), $postData)
            ->assertSessionHasErrors($invalidFields)
            ->assertStatus(302);
    }

    protected function invalidLogin()
    {
        return [
            [
                ['email' => '', 'password' => ''],
                ['email', 'password'],
            ],
            [
                ['email' => 'test@example.com', 'password' => ''],
                ['password'],
            ],
            [
                ['email' => '', 'password' => '1234567@'],
                ['email'],
            ],
            [
                ['email' => 'test123', 'password' => '1234567@'],
                ['email'],
            ],
            [
                ['email' => 'test123@example.com', 'password' => '1234567@'],
                ['email'],
            ]
        ];
    }
}

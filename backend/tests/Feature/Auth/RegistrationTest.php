<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
    
    /**
     * can_not_register_with_wrong_user_data
     *
     * @return void
     * @test
     */
    public function can_not_register_with_empty_data()
    {
        $response = $this->post('/register', []);
        $response->assertInvalid([
            'name' => 'The name field is required.',
            'email' => 'The email field is required.',
            'password' => 'The password field is required.',
        ]);
    }

    /**
     * can_not_register_with_wrong_user_data
     *
     * @return void
     * @test
     */
    public function name_validation()
    {
        $response = $this->post('/register', ['name' => str_repeat('a', 256)]);
        $response->assertInvalid(['name' => 'The name must not be greater than 255 characters.']);
        $response = $this->post('/register', ['name' => str_repeat('a', 255)]);
        $response->assertValid('name');
    }
}

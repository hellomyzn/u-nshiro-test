<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;

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
     * name_validation
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

    /**
     * email_validation
     *
     * @return void
     * @test
     */
    public function email_validation()
    {
        User::factory()->create(['email' => 'test@example.com']);
        $response_proper_email = $this->post('/register', ['email' => 'hoge']);
        $response_proper_email->assertInvalid(['email' => 'The email must be a valid email address.']);

        $response_unique = $this->post('/register', ['email' => 'test@example.com']);
        $response_unique->assertInvalid(['email' => 'The email has already been taken.']);
        
    }

    /**
     * password_validation
     *
     * @return void
     * @test
     */
    public function password_validation()
    {
        $response = $this->post('/register', ['password' => '1234567']);
        $response->assertInvalid(['password' => 'The password must be at least 8 characters.']);
        
        
    }
}

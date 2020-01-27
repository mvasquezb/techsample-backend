<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;
use Illuminate\Support\Str;


class UserTest extends TestCase
{
    use WithFaker;

    /**
     * Default user password
     * 
     * @var string
     */
    const USER_PASSWORD = '1234';

    /**
     * Test successful user registration.
     *
     * @return void
     */
    public function testRegisterSuccess()
    {
        $user = factory(\App\User::class)->make();
        $email = $user->email;
        $response = $this->postJson('/api/register', $user->attributesToArray() + [
            'password' => self::USER_PASSWORD,
            'password_confirmation' => self::USER_PASSWORD,
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $email
        ]);
    }

    /**
     * Test user registration error because of existing fields.
     *
     * @return void
     */
    public function testRegisterFailUserExists()
    {
        $existingUser = factory(\App\User::class)->create([
            'gamertag' => 'test'
        ]);
        $newUser = factory(\App\User::class)->make([
            'gamertag' => 'test'
        ]);
        $response = $this->postJson('/api/register', $newUser->attributesToArray() + [
            'password' => self::USER_PASSWORD,
            'password_confirmation' => self::USER_PASSWORD,
        ]);

        $response
            ->assertStatus(400)
            ->assertJsonStructure([
                'errors'
            ]);
    }

    /**
     * Test successful login
     * 
     * @return void
     */
    public function testLoginSuccess()
    {
        $user = factory(\App\User::class)->create([
            'password' => bcrypt(self::USER_PASSWORD),
        ]);
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => self::USER_PASSWORD
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'token'
            ]);
    }

    /**
     * Test unsuccessful login
     * 
     * @return void
     */
    public function testLoginFail()
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->faker->email,
            'password' => $this->faker->password
        ]);

        $response
            ->assertStatus(401)
            ->assertJsonStructure([
                'errors'
            ]);
    }

    /**
     * Test accessing login through web returns json errors
     * 
     * @return void
     */
    public function testLoginThroughWeb()
    {
        $response = $this->get('/api/login', [
            'email' => $this->faker->email,
            'password' => $this->faker->password
        ]);

        $response
            ->assertStatus(400)
            ->assertJsonStructure([
                'errors'
            ]);
    }

    /**
     * Test create password reset token success
     * 
     * @return void
     */
    public function testForgotPasswordSuccess()
    {
        $user = factory(\App\User::class)->create([
            'password' => bcrypt(self::USER_PASSWORD)
        ]);
        $response = $this
            ->actingAs($user)
            ->postJson('/api/forgot-password', [
                'email' => $user->email
            ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'token'
            ]);
    }

    /**
     * Test create password reset token failure
     * 
     * @return void
     */
    public function testForgotPasswordFail()
    {
        $email = $this->faker->email;
        $response = $this->postJson('/api/forgot-password', [
            'email' => $email
        ]);
        $response
            ->assertStatus(401)
            ->assertJsonStructure([
                'errors'
            ]);
    }

    /**
     * Test password reset success
     * 
     * @return void
     */
    public function testPasswordResetSuccess()
    {
        $user = factory(\App\User::class)->create([
            'password' => bcrypt(self::USER_PASSWORD)
        ]);
        $broker = Password::broker();
        $token = $broker->createToken($user);
        $newPassword = $this->faker->password;
        
        $response = $this->postJson('/api/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword
        ]);

        $response
            ->assertSuccessful()
            ->assertJsonStructure([
                'token',
                'user'
            ]);
        
        $user->refresh();
        $this->assertFalse(Hash::check(self::USER_PASSWORD, $user->password));
        $this->assertTrue(Hash::check($newPassword, $user->password));
    }

    /**
     * Test password reset failure (invalid token)
     * 
     * @return void
     */
    public function testPasswordResetFail()
    {
        $user = factory(\App\User::class)->create([
            'password' => bcrypt(self::USER_PASSWORD)
        ]);
        $token = Str::random();
        $newPassword = $this->faker->password;
        
        $response = $this->postJson('/api/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword
        ]);

        $response
            ->assertUnauthorized()
            ->assertJsonStructure([
                'errors'
            ]);
        
        $this->assertTrue(Hash::check(self::USER_PASSWORD, $user->password));
    }
}

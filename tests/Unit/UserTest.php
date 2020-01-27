<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;


class UserTest extends TestCase
{
    use WithFaker;

    /**
     * Test successful user registration.
     *
     * @return void
     */
    public function testRegisterSuccess()
    {
        $user = factory(\App\User::class)->make();
        $email = $user->email;
        $response = $this->json('POST', '/api/register', $user->attributesToArray() + [
            'password' => '1234',
            'password_confirmation' => '1234',
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
        $response = $this->json('POST', '/api/register', $newUser->attributesToArray() + [
            'password' => '1234',
            'password_confirmation' => '1234',
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
            'password' => bcrypt('1234'),
        ]);
        $response = $this->json('POST', '/api/login', [
            'email' => $user->email,
            'password' => '1234'
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
        $response = $this->json('POST', '/api/login', [
            'email' => $this->faker->email,
            'password' => $this->faker->password
        ]);

        $response
            ->assertStatus(401)
            ->assertJsonStructure([
                'errors'
            ]);
    }
}

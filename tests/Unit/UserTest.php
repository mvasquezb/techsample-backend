<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Str;


class UserTest extends TestCase
{
    /**
     * Test successful user registration.
     *
     * @return void
     */
    public function testRegisterSuccess()
    {
        $user = factory(\App\User::class)->make();
        $response = $this->json('POST', '/api/register', $user->attributesToArray() + [
            'password' => '1234',
            'password_confirmation' => '1234',
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);
    }

    /**
     * Test user registration error because of existing fields.
     *
     * @return void
     */
    public function testRegisterErrorUserExists()
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
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Str;


class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testRegisterSuccessTest()
    {
        $response = $this->json('POST', '/api/register', [
            'name' => 'Sally',
            'email' => "test_". Str::random(5) . "@mail.com",
            'password' => '1234',
            'password_confirmation' => '1234',
            'address1' => '310 Flora Tristan',
            'gender' => 'male',
            'city' => 'Lima',
            'country' => 'Peru',
            'zipCode' => '15076',
            'userType' => 'developer',
            'gameTitle' => 'Game asd',
            'gamertag' => 'AGames',
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data'
            ]);
    }


}

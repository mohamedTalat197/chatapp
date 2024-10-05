<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_user_registration_successful()
    {
        $this->withoutExceptionHandling();
        $data = [
            'username' => 'mo30',
            'email' => 'mo94414@mail.com',
            'password' => '1234567',
        ];
        $response = $this->postJson('/api/auth/register', $data, ['lang' => 'en']);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'username',
                    'email',
                    'is_online',
                    'last_seen',
                    'created_at',
                    'token',
                ],
            ]);
        $this->assertDatabaseHas('users', [
            'email' => 'mo94451@mail.com',
        ]);
    }

    public function test_user_registration_fails_due_to_duplicate_email()
    {
        User::create([
            'username' => 'mo',
            'email' => 'mo1@mail.com',
            'password' => Hash::make('1234567'),
        ]);

        $data = [
            'username' => 'mo',
            'email' => 'mo1@mail.com',
            'password' => '1234567',
        ];

        $response = $this->postJson('/api/auth/register', $data, ['lang' => 'en']);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJson([
            'error' => __('validationMessage.email_unique'),
        ]);
    }

}

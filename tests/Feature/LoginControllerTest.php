<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Response;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_login_successful()
    {
        $user = User::create([
            'username' => 'mohamed',
            'email' => 'test@example.com',
            'password' => Hash::make('1234567'),
        ]);

        $data = [
            'email' => 'test@example.com',
            'password' => '1234567',
        ];
        $response = $this->postJson('/api/auth/login', $data, ['lang' => 'en']);
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
    }

    public function test_user_login_fails_due_to_invalid_email()
    {
        $data = [
            'email' => 'mohamed@example.com',
            'password' => '1234567',
        ];
        $response = $this->postJson('/api/auth/login', $data, ['lang' => 'en']);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'error' => __('responseMessage.user_not_found'),
            ]);
    }

}

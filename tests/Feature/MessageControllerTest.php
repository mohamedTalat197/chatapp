<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Response;

class MessageControllerTest extends TestCase
{

    public function test_user_can_send_message_successfully()
    {
        $sender = User::create([
            'username' => 'Mohamed',
            'email' => 'sender1@example.com',
            'password' => bcrypt('1234567'),
        ]);
        $recipient = User::create([
            'username' => 'ahmed',
            'email' => 'recipient1@example.com',
            'password' => bcrypt('1234567'),
        ]);
        $this->actingAs($sender);
        $data = [
            'recipient_id' => $recipient->id,
            'content' => 'Hello, this is a test message',
        ];
        $response = $this->postJson('/api/message/send_message', $data, ['lang' => 'en']);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'sender_id',
                    'recipient_id',
                    'content',
                    'created_at',
                    'updated_at',
                ],
            ]);
        $this->assertDatabaseHas('messages', [
            'content' => 'Hello, this is a test message!',
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
        ]);
    }

    public function test_user_cannot_send_message_without_recipient()
    {
        $sender = User::create([
            'username' => 'mohamed',
            'email' => 'sender3@example.com',
            'password' => bcrypt('1234567'),
        ]);
        $this->actingAs($sender);
        $data = [
            'content' => 'This message has no recipient.',
        ];
        $response = $this->postJson('/api/message/send_message', $data, ['lang' => 'en']);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'error' => __('validationMessage.recipient_required'),
            ]);
    }

    public function test_user_can_mark_messages_as_seen()
    {
        $user = User::create([
            'username' => 'ffff',
            'email' => 'fff@example.com',
            'password' => bcrypt('1234567'),
        ]);
        $this->actingAs($user);

        $message1 = Message::create([
            'sender_id' => $user->id,
            'recipient_id' => $user->id,
            'content' => 'First message',
            'is_seen' => 0,
        ]);

        $message2 = Message::create([
            'sender_id' => $user->id,
            'recipient_id' => $user->id,
            'content' => 'Second message',
            'is_seen' => 0,
        ]);
        $data = [
            'message_ids' => json_encode([$message1->id, $message2->id]),
        ];
        $response = $this->postJson('/api/message/mark_as_seen', $data, ['lang' => 'en']);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'success' => 1,
                'message' => 'success',
            ]);
        $this->assertDatabaseHas('messages', [
            'id' => $message1->id,
            'is_seen' => 1,
        ]);
        $this->assertDatabaseHas('messages', [
            'id' => $message2->id,
            'is_seen' => 1,
        ]);
    }

    public function test_user_cannot_mark_messages_as_seen_with_invalid_ids()
    {
        $user = User::create([
            'username' => 'mohamed',
            'email' => 'ss@example.com',
            'password' => bcrypt('1234567'),
        ]);
        $this->actingAs($user);
        $data = [
            'message_ids' => json_encode([]),
        ];
        $response = $this->postJson('/api/message/mark_as_seen', $data, ['lang' => 'en']);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'success' => 1,
                'message' => 'success',
            ]);
    }

}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_valid_data(): void
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'user' => ['id', 'name', 'email', 'created_at', 'updated_at'],
                    'token',
                    'token_type',
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'User registered successfully',
                'data' => [
                    'user' => [
                        'name' => 'John Doe',
                        'email' => 'johndoe@example.com',
                    ],
                    'token_type' => 'Bearer',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com',
            'name' => 'John Doe',
        ]);
    }

    public function test_user_registration_fails_with_invalid_data(): void
    {
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validation Error',
                'data' => null,
            ]);
    }

    public function test_user_registration_fails_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'duplicate@example.com']);

        $response = $this->postJson('/api/register', [
            'name' => 'Duplicate User',
            'email' => 'duplicate@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validation Error',
                'data' => null,
            ]);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'jane@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'jane@example.com',
            'password' => 'secret123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'user' => ['id', 'name', 'email'],
                    'token',
                    'token_type',
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'User logged in successfully',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'email' => 'jane@example.com',
                    ],
                    'token_type' => 'Bearer',
                ],
            ]);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'valid@example.com',
            'password' => bcrypt('correct_password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'valid@example.com',
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validation Error',
                'data' => null,
            ]);
    }

    public function test_authenticated_user_can_view_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/user');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User profile retrieved successfully',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'email' => $user->email,
                    ],
                ],
            ]);
    }

    public function test_unauthenticated_user_cannot_view_profile(): void
    {
        $response = $this->getJson('/api/user');

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthorized access. Please provide a valid authentication token.',
                'data' => null,
            ]);
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logged out successfully',
            ]);

        $this->assertCount(0, $user->fresh()->tokens);
    }
}

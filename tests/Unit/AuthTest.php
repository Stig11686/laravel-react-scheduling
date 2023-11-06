<?php

namespace Tests\Unit;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class AuthTest extends TestCase
{

    public function test_successful_login_as_learner()
    {

        $userData = [
            'email' => 'test@example.com',
            'password' => 'password123'
        ];

        $user = User::where('email', $userData['email'])->first();

        if(!$user){
            $user = User::factory()->create($userData);
        }

        //if user doesnt exist - create - TODO
        // $user = User::factory()->create($userData);

        $user->assignRole('learner');

        $response = $this->postJson('/api/login', $userData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    // Include other user attributes here
                ],
                'token'
            ]);
    }

    public function test_invalid_credentials_login()
    {
        $invalidUserData = [
            'email' => 'invalid@example', // Invalid email format
            'password' => 'wrongpassword'
        ];

        $response = $this->postJson('/api/login', $invalidUserData);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email' // Check if 'email' key exists in the 'errors' array
                ]
            ])
            ->assertJson([
                'message' => 'The selected email is invalid.',
                'errors' => [
                    'email' => ['The selected email is invalid.'] // Check the specific validation error message
                ]
            ]);
    }


    public function test_successful_logout()
    {
        $user = User::factory()->create();
        $user->assignRole('learner');
        Sanctum::actingAs($user, ['*']);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(204);
    }
}

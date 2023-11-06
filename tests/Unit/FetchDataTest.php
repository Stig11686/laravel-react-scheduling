<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class FetchDataTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

       // Check if user already exists, if not, create it
        $this->user = User::with('roles', 'permissions')->where('email', 'stevenmarks75@gmail.com')->first();
        if (!$this->user) {
            $this->user = User::factory()->create(['email' => 'stevenmarks75@gmail.com']);
            $this->user->assignRole('super-admin');
        }

        // Create token if it doesn't exist
        $this->token = $this->user->tokens->first();
        if (!$this->token) {
            $this->token = $this->user->createToken('test-token')->plainTextToken;
        }

        Sanctum::actingAs($this->user, ['*']);
    }


    public function test_can_get_list_of_courses()
    {
        $response = $this->get('/api/courses');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        // Include other course attributes here
                    ]
                ]
            ]);
    }

    public function test_can_get_list_of_cohorts()
    {
        $response = $this->get('/api/cohorts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'course',
                            'course_id',
                            'start_date',
                            'end_date',
                            'places',
                            'learners'
                            // Include other cohort attributes here
                        ]
                    ],
                    'pagination'
            ]);
    }

    public function test_can_get_list_of_all_sessions_as_admin()
    {
        $response = $this->get('/api/sessions');

        $response->assertStatus(200)
            ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'trainer_notes',
                            'slides',
                            'review_status',
                            'review_due',
                            // Include other cohort attributes here
                        ]
                    ],
                    'pagination'
            ]);
    }

    public function test_can_get_list_of_sessions_as_learner(){
        $learnerUser = User::whereHas('roles', function ($query) {
            $query->where('name', 'learner');
        })->first();

        // If no learner user exists, create one
        if (!$learnerUser) {
            $learnerUser = factory(User::class)->create();
            $learnerUser->assignRole('learner');
        }

        $this->user = $learnerUser;

        $response = $this->get('/api/schedule');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'course_name',
                        'cohort_name',
                        'sessions' => [
                            '*' => [
                                'id',
                                'date',
                                'name',
                                'trainer',
                                'zoom_room',
                                'slides'
                            ]
                        ],

                    ]
                ]
            ]);
    }

    // Add similar assertions for show, store, update, and destroy methods
}


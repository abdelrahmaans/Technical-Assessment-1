<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_unauthenticated_user_cannot_access_course_endpoints(): void
    {
        $this->getJson('/api/courses')->assertStatus(401);
        $this->postJson('/api/courses', ['title' => 'Test'])->assertStatus(401);
        $this->getJson('/api/courses/1')->assertStatus(401);
        $this->putJson('/api/courses/1', ['title' => 'Test'])->assertStatus(401);
        $this->deleteJson('/api/courses/1')->assertStatus(401);
    }

    public function test_authenticated_user_can_list_courses_with_pagination(): void
    {
        Course::factory()->count(15)->create();

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/courses?page=2&per_page=10');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'items' => [
                        '*' => ['id', 'title', 'description', 'price', 'is_published', 'created_at', 'updated_at'],
                    ],
                    'pagination' => [
                        'current_page',
                        'per_page',
                        'total',
                        'last_page',
                        'from',
                        'to',
                        'has_more_pages',
                    ],
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Courses retrieved successfully',
                'data' => [
                    'pagination' => [
                        'current_page' => 2,
                        'per_page' => 10,
                        'total' => 15,
                        'last_page' => 2,
                    ],
                ],
            ]);

        $this->assertCount(5, $response->json('data.items'));
    }

    public function test_authenticated_user_can_search_courses_by_title(): void
    {
        Course::factory()->create(['title' => 'Mastering Laravel Framework']);
        Course::factory()->create(['title' => 'Vue.js 3 Fundamentals']);
        Course::factory()->create(['title' => 'Advanced Laravel Sanctum']);

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/courses?search=Laravel');

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data.items'));
    }

    public function test_authenticated_user_can_filter_courses_by_published_status(): void
    {
        Course::factory()->create(['title' => 'Published Course 1', 'is_published' => true]);
        Course::factory()->create(['title' => 'Draft Course 1', 'is_published' => false]);
        Course::factory()->create(['title' => 'Published Course 2', 'is_published' => true]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/courses?published=true');

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data.items'));

        $draftResponse = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/courses?published=false');

        $draftResponse->assertStatus(200);
        $this->assertCount(1, $draftResponse->json('data.items'));
    }

    public function test_courses_are_sorted_by_created_at_descending(): void
    {
        $course1 = Course::factory()->create([
            'title' => 'Old Course',
            'created_at' => now()->subDays(5),
        ]);
        $course2 = Course::factory()->create([
            'title' => 'New Course',
            'created_at' => now(),
        ]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/courses');

        $response->assertStatus(200);
        $items = $response->json('data.items');
        $this->assertEquals($course2->id, $items[0]['id']);
        $this->assertEquals($course1->id, $items[1]['id']);
    }

    public function test_authenticated_user_can_create_course(): void
    {
        $payload = [
            'title' => 'RESTful API with Laravel',
            'description' => 'A comprehensive guide to building APIs',
            'price' => 49.99,
            'is_published' => true,
        ];

        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/courses', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Course created successfully',
                'data' => [
                    'title' => 'RESTful API with Laravel',
                    'price' => 49.99,
                    'is_published' => true,
                ],
            ]);

        $this->assertDatabaseHas('courses', [
            'title' => 'RESTful API with Laravel',
            'price' => 49.99,
        ]);
    }

    public function test_course_creation_fails_validation_without_required_title(): void
    {
        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/courses', [
                'description' => 'Missing title',
            ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validation Error',
                'data' => null,
            ]);
    }

    public function test_authenticated_user_can_view_single_course(): void
    {
        $course = Course::factory()->create([
            'title' => 'Unique Course Title',
            'price' => 29.99,
        ]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson("/api/courses/{$course->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Course retrieved successfully',
                'data' => [
                    'id' => $course->id,
                    'title' => 'Unique Course Title',
                    'price' => 29.99,
                ],
            ]);
    }

    public function test_viewing_nonexistent_course_returns_404(): void
    {
        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/courses/99999');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Resource not found',
                'data' => null,
            ]);
    }

    public function test_authenticated_user_can_update_course(): void
    {
        $course = Course::factory()->create([
            'title' => 'Original Title',
            'price' => 19.99,
        ]);

        $payload = [
            'title' => 'Updated Title',
            'price' => 39.99,
            'is_published' => true,
        ];

        $response = $this->actingAs($this->user, 'sanctum')
            ->putJson("/api/courses/{$course->id}", $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Course updated successfully',
                'data' => [
                    'id' => $course->id,
                    'title' => 'Updated Title',
                    'price' => 39.99,
                    'is_published' => true,
                ],
            ]);

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'title' => 'Updated Title',
            'price' => 39.99,
        ]);
    }

    public function test_authenticated_user_can_delete_course(): void
    {
        $course = Course::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')
            ->deleteJson("/api/courses/{$course->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Course deleted successfully',
            ]);

        $this->assertDatabaseMissing('courses', [
            'id' => $course->id,
        ]);
    }

    public function test_deleting_nonexistent_course_returns_404(): void
    {
        $response = $this->actingAs($this->user, 'sanctum')
            ->deleteJson('/api/courses/99999');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Resource not found',
                'data' => null,
            ]);
    }
}

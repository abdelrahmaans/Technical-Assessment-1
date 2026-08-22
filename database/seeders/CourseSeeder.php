<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sampleCourses = [
            [
                'title' => 'Mastering Laravel 11 RESTful API Development',
                'description' => 'Comprehensive guide to building production-ready, scalable REST APIs using modern Laravel techniques, Sanctum, and clean architecture.',
                'price' => 99.99,
                'is_published' => true,
                'created_at' => now()->subDays(10),
            ],
            [
                'title' => 'PHP 8.3 Advanced Object-Oriented Programming',
                'description' => 'Deep dive into OOP design patterns, SOLID principles, attributes, type system, and modern PHP best practices.',
                'price' => 79.50,
                'is_published' => true,
                'created_at' => now()->subDays(9),
            ],
            [
                'title' => 'Laravel Sanctum & API Security Fundamentals',
                'description' => 'Learn how to secure Single Page Applications and Mobile REST APIs with token-based authentication and ability scopes.',
                'price' => 49.00,
                'is_published' => true,
                'created_at' => now()->subDays(8),
            ],
            [
                'title' => 'Test-Driven Development (TDD) in Laravel',
                'description' => 'Master automated testing using PHPUnit and Pest. Write unit, integration, and feature tests with confidence.',
                'price' => 89.99,
                'is_published' => true,
                'created_at' => now()->subDays(7),
            ],
            [
                'title' => 'Database Design & Optimization for High Traffic APIs',
                'description' => 'Advanced indexing, query optimization, caching strategies with Redis, and database normalization for backend developers.',
                'price' => 120.00,
                'is_published' => true,
                'created_at' => now()->subDays(6),
            ],
            [
                'title' => 'Clean Code and Architecture Patterns in Laravel',
                'description' => 'Implement Repository Pattern, Service Layer, Action classes, and DTOs to create maintainable enterprise codebases.',
                'price' => 110.50,
                'is_published' => true,
                'created_at' => now()->subDays(5),
            ],
            [
                'title' => 'Full-Stack Vue.js 3 & Laravel API Integration',
                'description' => 'Build reactive modern web applications connecting Vue 3 frontend with Laravel RESTful APIs.',
                'price' => 95.00,
                'is_published' => false,
                'created_at' => now()->subDays(4),
            ],
            [
                'title' => 'Microservices Architecture with Docker & Laravel',
                'description' => 'Design, containerize, and deploy distributed microservices architectures with Docker, RabbitMQ, and Laravel.',
                'price' => 150.00,
                'is_published' => false,
                'created_at' => now()->subDays(3),
            ],
            [
                'title' => 'Git & GitHub Collaboration for Backend Teams',
                'description' => 'Learn professional branching workflows, semantic commits, code reviews, and CI/CD automated pipelines.',
                'price' => 29.99,
                'is_published' => true,
                'created_at' => now()->subDays(2),
            ],
            [
                'title' => 'Laravel Eloquent ORM: From Beginner to Pro',
                'description' => 'Unlock the full power of Eloquent relationships, polymorphic relations, query scopes, and eager loading optimization.',
                'price' => 65.00,
                'is_published' => true,
                'created_at' => now()->subDay(),
            ],
        ];

        foreach ($sampleCourses as $course) {
            Course::create($course);
        }
    }
}

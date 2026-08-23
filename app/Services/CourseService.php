<?php

namespace App\Services;

use App\Models\Course;
use App\Repositories\Contracts\CourseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CourseService
{
    /**
     * @param  \App\Repositories\Contracts\CourseRepositoryInterface  $courseRepository
     */
    public function __construct(
        protected CourseRepositoryInterface $courseRepository
    ) {}

    /**
     * List courses with filtering, pagination, and sorting.
     *
     * @param  array  $filters
     * @param  int  $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listCourses(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->courseRepository->getPaginatedCourses($filters, $perPage);
    }

    /**
     * Get a course by ID.
     *
     * @param  int  $id
     * @return \App\Models\Course
     */
    public function getCourse(int $id): Course
    {
        return $this->courseRepository->findOrFail($id);
    }

    /**
     * Create a new course with Database Transaction.
     *
     * @param  array  $data
     * @return \App\Models\Course
     */
    public function createCourse(array $data): Course
    {
        return DB::transaction(function () use ($data) {
            return $this->courseRepository->create($data);
        });
    }

    /**
     * Update an existing course with Database Transaction.
     *
     * @param  int  $id
     * @param  array  $data
     * @return \App\Models\Course
     */
    public function updateCourse(int $id, array $data): Course
    {
        return DB::transaction(function () use ($id, $data) {
            $course = $this->courseRepository->findOrFail($id);
            return $this->courseRepository->update($course, $data);
        });
    }

    /**
     * Delete a course with Database Transaction.
     *
     * @param  int  $id
     * @return void
     */
    public function deleteCourse(int $id): void
    {
        DB::transaction(function () use ($id) {
            $course = $this->courseRepository->findOrFail($id);
            $this->courseRepository->delete($course);
        });
    }
}

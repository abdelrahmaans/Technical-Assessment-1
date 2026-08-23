<?php

namespace App\Repositories\Contracts;

use App\Models\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CourseRepositoryInterface
{
    /**
     * Get paginated and filtered courses sorted by newest first.
     *
     * @param  array  $filters
     * @param  int  $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedCourses(array $filters = [], int $perPage = 10): LengthAwarePaginator;

    /**
     * Find a course by its ID.
     *
     * @param  int  $id
     * @return \App\Models\Course|null
     */
    public function findById(int $id): ?Course;

    /**
     * Find a course by its ID or throw ModelNotFoundException.
     *
     * @param  int  $id
     * @return \App\Models\Course
     */
    public function findOrFail(int $id): Course;

    /**
     * Create a new course record.
     *
     * @param  array  $data
     * @return \App\Models\Course
     */
    public function create(array $data): Course;

    /**
     * Update an existing course record.
     *
     * @param  \App\Models\Course  $course
     * @param  array  $data
     * @return \App\Models\Course
     */
    public function update(Course $course, array $data): Course;

    /**
     * Delete a course record.
     *
     * @param  \App\Models\Course  $course
     * @return bool|null
     */
    public function delete(Course $course): ?bool;
}

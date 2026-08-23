<?php

namespace App\Repositories\Eloquent;

use App\Models\Course;
use App\Repositories\Contracts\CourseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CourseRepository implements CourseRepositoryInterface
{
    /**
     * Get paginated and filtered courses sorted by newest first (created_at DESC).
     *
     * @param  array  $filters
     * @param  int  $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedCourses(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Course::query();

        // Filter by title search
        if (! empty($filters['search'])) {
            $query->search($filters['search']);
        }

        // Filter by published status
        if (isset($filters['published'])) {
            $query->published($filters['published']);
        }

        // Always sort by created_at descending (newest first)
        return $query->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Find a course by its ID.
     *
     * @param  int  $id
     * @return \App\Models\Course|null
     */
    public function findById(int $id): ?Course
    {
        return Course::find($id);
    }

    /**
     * Find a course by its ID or throw ModelNotFoundException.
     *
     * @param  int  $id
     * @return \App\Models\Course
     */
    public function findOrFail(int $id): Course
    {
        return Course::findOrFail($id);
    }

    /**
     * Create a new course record.
     *
     * @param  array  $data
     * @return \App\Models\Course
     */
    public function create(array $data): Course
    {
        return Course::create($data);
    }

    /**
     * Update an existing course record.
     *
     * @param  \App\Models\Course  $course
     * @param  array  $data
     * @return \App\Models\Course
     */
    public function update(Course $course, array $data): Course
    {
        $course->update($data);
        return $course->refresh();
    }

    /**
     * Delete a course record.
     *
     * @param  \App\Models\Course  $course
     * @return bool|null
     */
    public function delete(Course $course): ?bool
    {
        return $course->delete();
    }
}

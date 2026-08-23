<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Services\CourseService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param  \App\Services\CourseService  $courseService
     */
    public function __construct(
        protected CourseService $courseService
    ) {}

    /**
     * Display a paginated listing of the courses.
     * Supports ?search=, ?page=, ?published=, ?per_page=
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 10);
        $filters = $request->only(['search', 'published']);

        $paginator = $this->courseService->listCourses($filters, $perPage);

        return $this->successResponse([
            'items' => CourseResource::collection($paginator->items()),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'has_more_pages' => $paginator->hasMorePages(),
            ],
        ], 'Courses retrieved successfully', Response::HTTP_OK);
    }

    /**
     * Store a newly created course in storage.
     *
     * @param  \App\Http\Requests\Course\StoreCourseRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCourseRequest $request): JsonResponse
    {
        $course = $this->courseService->createCourse($request->validated());

        return $this->successResponse(
            new CourseResource($course),
            'Course created successfully',
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified course.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $course = $this->courseService->getCourse($id);

        return $this->successResponse(
            new CourseResource($course),
            'Course retrieved successfully',
            Response::HTTP_OK
        );
    }

    /**
     * Update the specified course in storage.
     *
     * @param  \App\Http\Requests\Course\UpdateCourseRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCourseRequest $request, int $id): JsonResponse
    {
        $course = $this->courseService->updateCourse($id, $request->validated());

        return $this->successResponse(
            new CourseResource($course),
            'Course updated successfully',
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified course from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->courseService->deleteCourse($id);

        return $this->successResponse(
            (object) [],
            'Course deleted successfully',
            Response::HTTP_OK
        );
    }
}

<?php

namespace App\Services\Api;

use App\Traits\Singleton;

class CanvasApi extends BaseApi
{
    use Singleton;

    public function __construct()
    {
        $baseUrl = env('CANVAS_API_URL');
        $accessToken = env('CANVAS_API_KEY');
        $this->baseHeaders["Authorization"] = "Bearer {$accessToken}";
        parent::__construct($baseUrl);
    }

    public function getPagedData($endPoint, $params = [])
    {
        $params = array_merge(
            $params,
            [
                'per_page' => 10,
                'page' => 1
            ]
        );
        $data = [];
        do {
            $response = $this->call('GET', $endPoint, $params);
            $thisData = json_decode($this->getResponseContent($response));
            $data = array_merge($data, $thisData);
            $params['page']++;
        } while (count($thisData) > 0);
        return $data;
    }

    public function getMyKids()
    {
        $endPoint = "api/v1/users/self/observees";
        return $this->getPagedData($endPoint);

    }

    public function getCourses()
    {
        $endPoint = 'api/v1/courses';
        return $this->getPagedData($endPoint);
    }

    public function getStudentCourses($studentId)
    {
        $endPoint = "api/v1/users/{$studentId}/courses";
        return $this->getPagedData($endPoint);
    }

    public function getActivitiyStream($courseId)
    {
        $endPoint = "api/v1/courses/{$courseId}/activity_stream";
        return $this->getPagedData($endPoint);

    }

    public function getModlules($courseId, $studentId)
    {
        $endPoint = "api/v1/courses/{$courseId}/modules";
        $params = ['student_id'=>$studentId];
        return $this->getPagedData($endPoint, $params);
    }

    public function getAssignments($courseId)
    {
        $endPoint = "api/v1/courses/{$courseId}/assignments";
    }

    public function getCourseSettings($courseId)
    {
        $endPoint = "api/v1/courses/{$courseId}/settings";
    }

    public function getUserSelf()
    {
        $endPoint = "api/v1/users/self";
        return $this->getPagedData($endPoint);
    }

    public function getStudentAssignments($courseId, $studentId)
    {
        $endPoint = "api/v1/users/{$studentId}/courses/{$courseId}/assignments";
    }

    public function getAssignment($courseId, $assignmentId)
    {
        $endPoint = "api/v1/courses/{$courseId}/assignments/{$assignmentId}";
    }
}

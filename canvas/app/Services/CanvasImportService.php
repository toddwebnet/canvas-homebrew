<?php

namespace App\Services;

use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Models\Course;
use App\Models\Student;
use App\Services\Api\CanvasApi;
use App\Services\Providers\AppSessionProvider;
use App\Traits\Singleton;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use Illuminate\Console\Command;

class CanvasImportService
{
    use Singleton;

    /** @var CanvasApi $canvasApi */
    private $canvasApi;
    private $familyId;

    public function __construct($canvasApi = null)
    {
        if ($canvasApi === null) {
            $canvasApi = CanvasApi::instance();
        }
        $this->canvasApi = $canvasApi;
        $this->familyId = AppSessionProvider::instance()->sessionFamilyId();
    }

    public function importStudents()
    {
        $students = $this->canvasApi->getMyKids();
        foreach ($students as $student) {
            $studentData = [];
            $doImport = true;
            try {
                $studentData = [
                    'id' => $student->id,
                    'family_id' => $this->familyId,
                    'name' => $student->name
                ];
            } catch (\Exception $e) {
                $doImport = false;
            }
            if ($doImport) {
                Student::updateOrCreate($studentData);
            }
        }

    }

    public function importCourses($studentId)
    {
        $courses = $this->canvasApi->getStudentCourses($studentId);

        foreach ($courses as $course) {

            if (!property_exists($course, 'name')) {
                continue;
            }
            if (property_exists($course, 'calendar') && property_exists($course->calendar, 'ics')) {
                $calendar = $course->calendar->ics;
            } else {
                $calendar = null;
            }
            $courseData = [
                'course_id' => $course->id,
                'student_id' => $studentId,
                'name' => $course->name,
                'code' => $course->course_code,
                'uuid' => $course->uuid,
                'calendar' => $calendar
            ];
            $course = Course::where('course_id', $courseData['course_id'])
                ->where('student_id', $studentId)
                ->first();
            if ($course == null) {
                Course::create($courseData);
            } else {
                Course::where('id', $course->id)->update($courseData);

            }

        }
    }

    public function getCourseModules($courseId, $studentId)
    {
        $modules = $this->canvasApi->getModules($courseId, $studentId);
        dd($modules);
    }

    public function getAssignments($courseId, $studentId)
    {
        $this->currentStatuses = [];
        $buckets = ['upcoming', 'overdue', 'unsubmitted'];

        foreach ($buckets as $bucket) {
            $defaultMaxPages = $this->canvasApi->maxPages;
            $this->canvasApi->maxPages = 10;
            $assignments = $this->canvasApi->getStudentAssignments($courseId, $studentId, $bucket);
            $this->canvasApi->maxPages = $defaultMaxPages;
            $this->processNewAssignments($courseId, $studentId, $assignments, $bucket);
        }

    }

    public function processNewAssignments($courseId, $studentId, $assignments, $bucket)
    {
        $date = date("Y-m-d", time());
        foreach ($assignments as $assignment) {
            $assignmentData = [
                'assignment_id' => $assignment->id,
                'course_id' => $courseId,
                'student_id' => $studentId,
                'name' => $assignment->name,
                'due_at' => Carbon::make($assignment->due_at)
            ];
            $assignment = Assignment::where(
                [
                    'assignment_id' => $assignment->id,
                    'course_id' => $courseId,
                    'student_id' => $studentId,
                ]
            )->first();
            if ($assignment === null) {
                $assignment = Assignment::create($assignmentData);
            } else {
                $assignment->update($assignmentData);
            }
            $this->updateAssignmentStatus($assignment, $bucket, $date);
        }
    }

    private $currentStatuses = [];

    private function updateAssignmentStatus($assignment, $bucket, $date)
    {
        if (!array_key_exists($assignment->id, $this->currentStatuses)) {

            AssignmentStatus::where([
                'assignment_id' => $assignment->id,
                'download_date' => $date
            ])->delete();

            AssignmentStatus::where([
                'assignment_id' => $assignment->id,
                'latest' => true
            ])->update(['latest' => false]);

            $this->currentStatuses[$assignment->id] = AssignmentStatus::create([
                'assignment_id' => $assignment->id,
                'download_date' => $date
            ]);
        }

        if ($bucket == 'overdue') {
            $this->currentStatuses[$assignment->id]->overdue_flag = true;
            $this->currentStatuses[$assignment->id]->save();
        }

        if ($bucket == 'unsubmitted') {
            $this->currentStatuses[$assignment->id]->overdue_flag = true;
            $this->currentStatuses[$assignment->id]->save();
        }


    }
}

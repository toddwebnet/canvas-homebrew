<?php

namespace App\Services;

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

    public function importStudentCourses()
    {
        foreach(Student::all() as $student){
            $this->importCourses($student->id);
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
                'id' => $course->id,
                'student_id' => $studentId,
                'name' => $course->name,
                'code' => $course->course_code,
                'uuid' => $course->uuid,
                'start_at' => Carbon::make($course->start_at),
                'calendar' => $calendar
            ];
            Course::updateOrCreate($courseData);
        }
    }
}

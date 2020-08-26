<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Student;
use App\Services\DateService;
use App\Services\Providers\AppSessionProvider;

class AppController extends Controller
{

    public function index()
    {
        $familyId = AppSessionProvider::instance()->sessionFamilyId();

        $data = [
            'students' => Student::where('family_id', $familyId)->get()
        ];
        return view('index', $data);

    }

    public function assignments($param1, $param2 = null)
    {
        /** @var DateService $dateService */

        if ($param2 == null) {
            $viewType = "Student";
            $course = null;
            $studentId = $param1;
            $assignments = Assignment::where('student_id', $studentId);
        } else {
            $viewType = "Course";
            $courseId = $param1;
            $course = Course::where('course_id', $courseId)->firstOrFail();
            $studentId = $param2;
            $assignments = Assignment::where('course_id', $courseId)
                ->where('student_id', $studentId);
        }
        $student = Student::find($studentId);

        list($weeks, $dateLabels, $first, $last) = DateService::instance()
            ->getDatesThisPrevNext(date("Y-m-d", strtotime('today')));
        $assignmentList = [];
        $assignments = $assignments
            ->where('due_at', '>=', date("Y-m-d", strtotime($first)))
            ->where('due_at', '<', date("Y-m-d", strtotime("$last + 1 day")))
            ->get();
        foreach ($assignments as $assignment) {
            $dateKey = date("Y-m-d", strtotime($assignment->due_at));
            if (array_key_exists($dateKey, $dateLabels))
                $dateGroup = $dateLabels[$dateKey];
            if (!array_key_exists($dateGroup, $assignmentList)) {
                $assignmentList[$dateGroup] = [];
            }
            if (!array_key_exists($dateKey, $assignmentList[$dateGroup])) {
                $assignmentList[$dateGroup][$dateKey] = [];
            }
            $assignmentList[$dateGroup][$dateKey][] = $assignment;
        }
        $dataCollection = [
            'viewType' => $viewType,
            'student' => $student,
            'course' => $course,
            'weeks' => $weeks,
            'assignmentList' => $assignmentList,
        ];
        return view('assignments', $dataCollection);
    }
}

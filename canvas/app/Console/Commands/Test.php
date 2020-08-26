<?php

namespace App\Console\Commands;

use App\Models\Student;
use App\Services\CanvasImportService;
use Illuminate\Console\Command;

class Test extends Command
{
    protected $signature = 'test';

    public function handle()
    {

        /** @var CanvasImportService $canvasImportService */
        $canvasImportService = CanvasImportService::instance();


//        $this->line('Importing Students');
//        $canvasImportService->importStudents();
//
//        foreach (Student::all() as $student) {
//            $this->line("Importing Courses for {$student->name}");
//            $canvasImportService->importCourses($student->id);
//        }
//        return;

        foreach (Student::all() as $student) {
            $this->line('Assignments for: ' . $student->name);
            foreach ($student->courses as $course) {
                $this->line('Course: ' . $course->name);
                $canvasImportService->getAssignments($course->course_id, $course->student_id);
            }
            $this->line('');
        }


    }
}

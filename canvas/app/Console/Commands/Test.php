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

        $canvasImportService->getCourseModules(366868, 351835);

    }
}

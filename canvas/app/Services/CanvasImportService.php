<?php

namespace App\Services;

use App\Models\Courses;
use App\Services\Api\CanvasApi;
use App\Traits\Singleton;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use Illuminate\Console\Command;

class CanvasImportService
{
    use Singleton;

    public function importCourses(Command $command = null)
    {
        /** @var CanvasApi $canvasApi */
        $canvasApi = CanvasApi::instance();

        if ($command) {
            $command->line('collecting courses from api');
        }
        /** @var Response $courses */
        $courses = $canvasApi->getCourses();
        if ($command) {
            $command->line('done collecting courses');
        }

        if ($command) {
            $command->line('inserting into database');
        }
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
                'canvas_id' => $course->id,
                'name' => $course->name,
                'code' => $course->course_code,
                'uuid' => $course->uuid,
                'start_at' => Carbon::make($course->start_at),
                'calendar' => $calendar
            ];
            Courses::updateOrCreate($courseData);
        }
        if ($command) {
            $command->line('done inserting into database');
        }
    }
}

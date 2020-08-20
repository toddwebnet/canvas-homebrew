<?php
namespace App\Console\Commands;

use App\Services\Api\CanvasApi;
use App\Services\CanvasImportService;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Illuminate\Console\Command;

class Test extends Command
{
    protected $signature = 'test';

    public function handle()
    {
        CanvasImportService::instance()->importCourses($this);

    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Student;
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
}

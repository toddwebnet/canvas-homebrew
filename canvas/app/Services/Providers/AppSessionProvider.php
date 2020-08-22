<?php

namespace App\Services\Providers;

use App\Models\Family;
use App\Traits\Singleton;

class AppSessionProvider
{
    use Singleton;
    public function sessionFamilyId()
    {
        return Family::first()->id;
    }
}

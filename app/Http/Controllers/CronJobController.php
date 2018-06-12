<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;

class CronJobController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    public function checkIfCourseIsActive()
    {
        Courses::where('hide_after_end', '1')
               ->where('isHide', 0)
               ->whereDate('is_open_to', '<', date('Y-m-d')) 
               ->update(['isHide' => '1']); 
    }
}

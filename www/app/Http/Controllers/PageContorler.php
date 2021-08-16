<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\ControllerMiddlewareOptions;

class PageContorler extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

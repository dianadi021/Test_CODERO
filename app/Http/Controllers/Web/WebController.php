<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use App\Traits\Tools;
use App\Traits\ResponseCode;
use App\Http\Controllers\Controller;

class WebController extends Controller
{
    use Tools, ResponseCode;

    public function Project(Request $req)
    {
        return view('master-data.project');
    }
}

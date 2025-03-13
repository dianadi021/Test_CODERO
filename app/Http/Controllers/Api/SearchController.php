<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Traits\Tools;
use App\Traits\ResponseCode;

use App\Services\Api\SearchService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\UserRequest;

class SearchController extends ApiController
{
    use ResponseCode, Tools;

    public function __construct(private SearchService $service)
    {
        parent::__construct($this->service);
    }


    public function index(Request $req) { return $this->GetAllDatas($req); }
}

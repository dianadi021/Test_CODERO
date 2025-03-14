<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Traits\Tools;
use App\Traits\ResponseCode;

use App\Services\Api\ProjectService;
use Illuminate\Http\JsonResponse;

class ProjectController extends ApiController
{
    use ResponseCode, Tools;

    public function __construct(private ProjectService $service)
    {
        parent::__construct($this->service);
    }


    public function index() { return $this->GetAllDatas(); }

    public function store(Request $req): JsonResponse
    {
        return $this->service->store($req);
    }

    public function show(string $id) { return $this->GetByID($id); }

    public function update(Request $req, string $id)
    {
        return $this->service->update($req, $id);
    }

    public function destroy(string $id) { return $this->DeleteByID($id); }
}

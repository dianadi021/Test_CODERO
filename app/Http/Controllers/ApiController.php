<?php

namespace App\Http\Controllers;

use Exception;

use App\Traits\Tools;
use App\Traits\ResponseCode;

use Illuminate\Http\JsonResponse;

abstract class ApiController extends Controller
{
    use ResponseCode, Tools;

    private $service;
    public function __construct($Service)
    {
        $this->service = new $Service;
    }

    public function GetAllDatas($req = null): JsonResponse
    {
        try {
            $datas = $this->service->index($req);

            return ($this->IsValidVal($datas) ? $this->OKE($datas) : $this->OKE([], "Data tidak ditemukan!"));
        } catch (Exception $err) {
            return $this->SERVER_ERROR($err->getMessage());
        }
    }

    public function GetByID(string $id): JsonResponse
    {
        try {
            $datas = $this->service->show($id);

            return ($this->IsValidVal($datas) ? $this->OKE($datas) : $this->OKE([], "Data tidak ditemukan!"));
        } catch (Exception $err) {
            return $this->SERVER_ERROR($err->getMessage());
        }
    }

    public function DeleteByID(string $id): JsonResponse
    {
        try {
            $datas = $this->service->destroy($id);

            return ($this->IsValidVal($datas) ? $this->OKE($datas) : $this->OKE([], "Data tidak ditemukan!"));
        } catch (Exception $err) {
            return $this->SERVER_ERROR($err->getMessage());
        }
    }
}

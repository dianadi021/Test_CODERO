<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use App\Traits\Tools;
use App\Traits\ResponseCode;

use App\Http\Requests\Api\UserRequest;

class SearchService
{
    use ResponseCode, Tools;
    private $dateNow, $selectColmn, $checkForm;
    public function __construct()
    {
        setlocale(LC_TIME, 'id_ID.utf8');
        $this->dateNow = now(env('APP_TIMEZONE', 'Asia/Jakarta'));
    }

    public function index(Request $req)
    {
        switch ($req->get_data) {
            case 'provinsi':
                $wheres = ($this->IsValidVal($req->id_provinsi) ? " WHERE prov.id = $req->id_provinsi AND " : " WHERE ");
                $wheres .= ($this->IsValidVal($req->q) ? " LOWER(prov.name) LIKE LOWER('%$req->q%') " : " 1=1 ");

                $qry = "SELECT prov.id, prov.name FROM provinsi prov $wheres ORDER BY prov.name ASC";
                $datas = DB::select("$qry");
                return $datas;
                break;

            case 'kabupaten':
                $wheres = ($this->IsValidVal($req->id_provinsi) ? " WHERE prov.id = $req->id_provinsi AND " : " WHERE ");
                $wheres .= ($this->IsValidVal($req->id_kabupaten) ? " kab.id = $req->id_kabupaten AND " : "");
                $wheres .= ($this->IsValidVal($req->q) ? " LOWER(kab.name) LIKE LOWER('%$req->q%') " : " 1=1 ");

                $qry = "SELECT kab.id, kab.name, kab.type, prov.name AS provinsi FROM kabupaten kab JOIN provinsi prov ON prov.id = kab.id_provinsi $wheres ORDER BY kab.name ASC";
                $datas = DB::select("$qry");
                return $datas;
                break;

            case 'kecamatan':
                $wheres = ($this->IsValidVal($req->id_provinsi) ? " WHERE prov.id = $req->id_provinsi AND " : " WHERE ");
                $wheres .= ($this->IsValidVal($req->id_kabupaten) ? " kab.id = $req->id_kabupaten AND " : "");
                $wheres .= ($this->IsValidVal($req->id_kecamatan) ? " kec.id = $req->id_kecamatan AND " : "");
                $wheres .= ($this->IsValidVal($req->q) ? " LOWER(kec.name) LIKE LOWER('%$req->q%') " : " 1=1 ");

                $qry = "SELECT kec.id, kec.name, kab.name AS kabupaten, prov.name AS provinsi FROM kecamatan kec JOIN kabupaten kab ON kab.id = kec.id_kabupaten JOIN provinsi prov ON prov.id = kab.id_provinsi $wheres ORDER BY kec.name ASC";
                $datas = DB::select("$qry");
                return $datas;
                break;

            case 'kelurahan':
                $wheres = ($this->IsValidVal($req->id_provinsi) ? " WHERE prov.id = $req->id_provinsi AND " : " WHERE ");
                $wheres .= ($this->IsValidVal($req->id_kabupaten) ? " kab.id = $req->id_kabupaten AND " : "");
                $wheres .= ($this->IsValidVal($req->id_kecamatan) ? " kec.id = $req->id_kecamatan AND " : "");
                $wheres .= ($this->IsValidVal($req->id_kelurahan) ? " kel.id = $req->id_kelurahan AND " : "");
                $wheres .= ($this->IsValidVal($req->q) ? " LOWER(kel.name) LIKE LOWER('%$req->q%') " : " 1=1 ");

                $qry = "SELECT kel.id, kel.name, kel.postal_code, kec.name AS kecamatan, kab.name AS kabupaten, prov.name AS provinsi FROM kelurahan kel JOIN kecamatan kec ON kec.id = kel.id_kecamatan JOIN kabupaten kab ON kab.id = kec.id_kabupaten JOIN provinsi prov ON prov.id = kab.id_provinsi $wheres ORDER BY kel.name ASC";
                $datas = DB::select("$qry");
                return $datas;
                break;

            case 'golongan_darah':
                $wheres = ($this->IsValidVal($req->id_goldar) ? " WHERE goldar.id = $req->id_goldar AND " : " WHERE ");
                $wheres .= ($this->IsValidVal($req->q) ? " LOWER(goldar.name) LIKE LOWER('$req->q%') " : " 1=1 ");

                $qry = "SELECT goldar.id, goldar.name FROM golongan_darah goldar $wheres ORDER BY goldar.name ASC";
                $datas = DB::select("$qry");
                return $datas;
                break;

            case 'roles':
                $wheres = ($this->IsValidVal($req->id_role) ? " WHERE rol.id = $req->id_role AND " : " WHERE ");
                $wheres .= ($this->IsValidVal($req->q) ? " LOWER(rol.name) LIKE LOWER('%$req->q%') " : " 1=1 ");

                $qry = "SELECT * FROM roles rol $wheres ORDER BY rol.level ASC";
                $datas = DB::select("$qry");
                return $datas;
                break;

            case 'users':
                $wheres = ($this->IsValidVal($req->id_user) ? " WHERE usr.id = $req->id_user AND " : " WHERE ");
                $wheres .= ($this->IsValidVal($req->id_role) ? " usr.id_role = $req->id_role AND " : "");
                $wheres .= ($this->IsValidVal($req->id_client) ? " usr.id_client = $req->id_client AND " : "");
                $wheres .= ($this->IsValidVal($req->q) ? " LOWER(usr.username) LIKE LOWER('%$req->q%') " : " 1=1 ");

                $qry = "SELECT usr.username, usr.email, usr.is_active, usr.id_role, rol.name AS role_name, pdd.fullname, usr.id_client FROM users usr JOIN penduduk pdd ON pdd.id = usr.id_penduduk JOIN roles rol ON rol.id = usr.id_role $wheres ";
                $datas = DB::select("$qry");
                return $datas;
                break;

            default:
                return [];
                break;
        }
    }
}

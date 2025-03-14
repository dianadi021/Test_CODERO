<?php

namespace App\Services\Api;

use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

use App\Traits\Tools;
use App\Traits\ResponseCode;

use App\Models\Project;

class ProjectService
{
    use ResponseCode, Tools;
    private $dateNow, $selectColmn, $checkForm;
    public function __construct()
    {
        setlocale(LC_TIME, 'id_ID.utf8');
        $this->dateNow = now(env('APP_TIMEZONE', 'Asia/Jakarta'));

        $this->selectColmn = [
            "*"
        ];

        $this->checkForm = [
            // Insert Project
            'project_name' => ['required', 'string'],
            'project_lead' => ['required', 'string'],
            'client_name' => ['required', 'string'],
            'leader_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'project_progress' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date', 'before_or_equal:end_date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_active' => ['nullable', 'string'],
            'is_deleted' => ['nullable', 'string'],
        ];
    }

    public function index()
    {
        return Project::get();
    }

    public function store(Request $req)
    {
        try {
            $validate = $this->ReqValidation($req, $this->checkForm);

            if ($req->hasFile('leader_photo')) {
                $leaderPhoto = $req->file('leader_photo');
                $path = 'storage/uploads/images/profiles';

                if (!file_exists(public_path($path))) {
                    mkdir(public_path($path), 0777, true);
                }

                $fileName = time() . '.' . $leaderPhoto->getClientOriginalExtension();
                $leaderPhoto->move(public_path($path), $fileName);

                $validate['leader_photo'] = "$path/$fileName";
            } else {
                $validate['leader_photo'] = (isset($req->old_leader_photo) ? $req->old_leader_photo : null);
            }

            $project = Project::create([
                'project_name' => $req->project_name,
                'project_lead' => $req->project_lead,
                'client_name' => $req->client_name,
                'leader_photo' => $validate['leader_photo'],
                'project_progress' => $req->project_progress,
                'start_date' => $this->ReformatDateTime($req->start_date, "Y-m-d H:i:s", true),
                'end_date' => $this->ReformatDateTime($req->end_date, "Y-m-d H:i:s", true),
            ]);

            if ($this->IsValidVal($project)) {
                return $this->OKE($project, "Data berhasil disimpan");
            } else {
                throw new ValidationException($validate);
            }
        } catch (ValidationException $err) {
            return $this->SERVER_ERROR($err->errors());
        }
    }

    public function show(string $id)
    {
        return Project::find($id);
    }

    public function edit(Request $req, string $id)
    {
        try {
            $validate = $this->ReqValidation($req, $this->checkForm);

            if ($req->hasFile('leader_photo')) {
                $validated['leader_photo'] = $req->file('leader_photo')->store('profiles', 'public');
            }

            $validate['leader_photo'] = (isset($validate['leader_photo']) ? asset("storage/" . $validated['leader_photo']) : null);

            $project = Project::find($id);

            $project->update([
                'project_name' => $req->project_name,
                'project_lead' => $req->project_lead,
                'client_name' => $req->client_name,
                'leader_photo' => $validate['leader_photo'],
                'project_progress' => $req->project_progress,
                'start_date' => $this->ReformatDateTime($req->start_date, "Y-m-d H:i:s", true),
                'end_date' => $this->ReformatDateTime($req->end_date, "Y-m-d H:i:s", true),
                'is_active' => $req->is_active,
                'is_deleted' => $req->is_deleted
            ]);

            if ($this->IsValidVal($project)) {
                return $this->OKE($project, "Data berhasil disimpan");
            } else {
                throw new ValidationException($validate);
            }
        } catch (ValidationException $err) {
            return $this->SERVER_ERROR($err->errors());
        }
    }

    public function destroy(string $id)
    {
        $user = Project::find($id);
        return $user->delete();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    protected $table = 'detail_project';
    use Notifiable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_name',
        'project_lead',
        'client_name',
        'leader_photo',
        'project_progress',
        'start_date',
        'end_date',
        'is_active',
        'is_deleted',
    ];
}

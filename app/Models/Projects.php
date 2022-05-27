<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;

    public $table = 'projects';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'priority',
        'cost',
        'rate',
        'image',
    ];


    public function user()
    {
        return $this->belongsToMany(UserProjects::class, 'user_projects', 'project_id', 'user_id');
    }

    public function tasks()
    {
        return $this->belongsToMany(Project_tasks::class, 'user_projects', 'project_id', 'tasks_id');
    }
}

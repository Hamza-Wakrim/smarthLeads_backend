<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    public $table = 'tasks';

    protected $fillable = [
        'title',
        'status',
    ];


    public function project()
    {
        return $this->belongsToMany(Project_tasks::class, 'project_tasks', 'tasks_id', 'project_id');
    }
}

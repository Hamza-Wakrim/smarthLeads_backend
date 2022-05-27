<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_tasks extends Model
{
    use HasFactory;


    public $table = 'project_tasks';

    protected $fillable = [
        'project_id',
        'tasks_id',
    ];
}


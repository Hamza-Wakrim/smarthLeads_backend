<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed user_id
 * @property mixed project_id
 */
class UserProjects extends Model
{
    use HasFactory;


    public $table = 'user_projects';

    protected $fillable = [
        'user_id',
        'project_id',
    ];
}

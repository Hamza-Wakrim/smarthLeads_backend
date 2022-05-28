<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designations extends Model
{
    use HasFactory;

    public $table = 'designations';

    protected $fillable = [
        'name',
        'department_id',
    ];

    public function departement(){
        return $this->belongsTo(Departements::class,'department_id');
    }
}

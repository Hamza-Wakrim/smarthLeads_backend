<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departements extends Model
{
    use HasFactory;

    public $table = 'departments';

    protected $fillable = [
        'name',
    ];


    public function designations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Designations::class,'department_id','id');
    }
}

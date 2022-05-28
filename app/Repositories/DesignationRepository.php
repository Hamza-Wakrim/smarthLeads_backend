<?php

namespace App\Repositories;

use App\Models\Designations;

class DesignationRepository
{
    protected $fieldSearchable = [
        'name',
        'department_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Designations::class;
    }
}

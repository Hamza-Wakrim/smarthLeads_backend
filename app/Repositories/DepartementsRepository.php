<?php

namespace App\Repositories;

use App\Models\Departements;

class DepartementsRepository
{    /**
 * @var array
 */
    protected $fieldSearchable = [
        'name',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Departements::class;
    }

}

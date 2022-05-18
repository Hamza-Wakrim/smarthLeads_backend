<?php

namespace App\Repositories;

use App\Models\Projects;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version July 10, 2018, 11:44 am UTC
 *
 * @method Projects findWithoutFail($id, $columns = ['*'])
 * @method Projects find($id, $columns = ['*'])
 * @method Projects first($columns = ['*'])
 */
class ProjectsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'priority',
        'image',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Projects::class;
    }
}

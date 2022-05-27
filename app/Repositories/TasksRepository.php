<?php

namespace App\Repositories;

use App\Models\Tasks;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version July 10, 2018, 11:44 am UTC
 *
 * @method Tasks findWithoutFail($id, $columns = ['*'])
 * @method Tasks find($id, $columns = ['*'])
 * @method Tasks first($columns = ['*'])
 */
class TasksRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'status',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tasks::class;
    }
}

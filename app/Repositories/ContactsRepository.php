<?php

namespace App\Repositories;

use App\Models\Contacts;

class ContactsRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'phone',
        'contact_id',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Contacts::class;
    }
}

<?php

namespace App\Repositories;

use App\Models\Invoices;

class InvoicesRepository
{
    protected $fieldSearchable = [
        'user_id',
        'due_date',
        'total',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Invoices::class;
    }
}

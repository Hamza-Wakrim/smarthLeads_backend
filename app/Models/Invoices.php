<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;


    public $table = 'invoices';

    protected $fillable = [
        'user_id',
        'due_date',
        'total',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}

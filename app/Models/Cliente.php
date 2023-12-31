<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'name',
        'lastname',
        'country',
        'city',
        'address',
        'phone',
        'numbersR',
        'email',
        'reference',
        'transaction_id',
        'quantity_numbers',
        'status',
    ];
}
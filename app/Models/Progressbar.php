<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progressbar extends Model
{
    use HasFactory;


    protected $table = 'progressbars';

    protected $fillable = [
        'status',
    ];
}

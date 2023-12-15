<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'raw_material',
        'quantity',
        'wax_batch_no',
        'wax_grade_no',
        'date', 
        'status'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    use HasFactory;

    protected $fillable = [
        'raw_material',
        'quantity',
        'wax_batch_no',
        'wax_grade_no',
        'date',
        'lab_id',
        'assign_for',
        'approved',
        'is_edit',
        'status'
    ];
}

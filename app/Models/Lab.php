<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_name',
        'parent_lab',
        'members',
        'status',
        'is_delete'
    ];

    public function getMembersCountAttribute()
    {
        return $this->hasMany(User::class, 'lab_id')->count();
    }


}

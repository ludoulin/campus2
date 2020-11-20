<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department;

class College extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'id'
    ];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}



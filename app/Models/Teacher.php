<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'courses',
        'contact_no',
        'email',
        'image',
    ];

    public function designations()
    {
        return $this->belongsToMany(Designation::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_teacher');
    }

}

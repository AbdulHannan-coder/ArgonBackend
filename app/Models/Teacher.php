<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department',
        'courses',
        'contact_no',
        'email',
        'image',
    ];

    public function designations()
    {
        return $this->belongsToMany(Designation::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{ protected $fillable = [
    'name',
    'image',
    'description',
    'price',
    'user_id'
];
    use HasFactory;
    public function curriculums(){
        return $this->hasMany(Curriculum::class);
    }

    public function students(){
        return $this->belongsToMany(User::class, 'course_student', 'course_id', 'user_id');
    }
    public function courses(){
        return $this->belongsToMany(Course::class);
    }
}

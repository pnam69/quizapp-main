<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassCourse extends Model
{
    protected $fillable = ['name', 'course_year', 'main_teacher_id'];

    // Relationship: students in this class
    public function students()
    {
        return $this->hasMany(User::class, 'class_course_id');
    }

    // Relationship: main teacher
    public function mainTeacher()
    {
        return $this->belongsTo(User::class, 'main_teacher_id');
    }
}

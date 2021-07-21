<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonCourses extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'curso_id', 'course_id', 'product_id', 'profile', 'lang', 'module_structure', 'screens_total', 'screens_titles', 'xml_src', 'creation_date'
    ];

    protected $table = 'tb_lesson_courses';

    public $timestamps = false;

    public function scopeGetLessonCourse($query, $lessonId, $lang){

        $data = $query->where('curso_id', $lessonId)->where('lang', $lang)->first();
        return $data;
	}
}

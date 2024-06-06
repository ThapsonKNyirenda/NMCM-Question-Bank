<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBlueprint extends Model
{
    use HasFactory;

    use Searchable;

    protected $fillable = [
        'cadre',
        'nursing_process',
        'disease_area',
        'taxonomy',
        'syllabus',
        'number_of_questions'
    ];
}

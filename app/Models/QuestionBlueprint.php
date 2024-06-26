<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBlueprint extends Model
{
    use HasFactory;

    use Searchable;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'cadre',
        'nursing_process',
        'disease_area',
        'taxonomy',
        'syllabus',
        'number_of_questions',
        'question_paper_code'
    ];

    public array $searchable = [
        'cadre',
        'nursing_process',
        'disease_area',
        'taxonomy',
        'syllabus',
        'number_of_questions',
        'question_paper_code'
    ];

    
}
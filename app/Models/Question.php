<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    use Searchable;
    use HasUuid;

    
    protected $fillable = [
        'uuid',
        'title',
        'cadre',
        'nursing_process',
        'disease_area',
        'syllabus',
        'question_description',
        'choice_a',
        'choice_b',
        'choice_c',
        'choice_d',
        'correct_answer',
        'status',
    ];

    public array $searchable = [
        'title',
        'cadre',
        'nursing_process',
        'disease_area',
        'syllabus',
        'question_description',
        'choice_a',
        'choice_b',
        'choice_c',
        'choice_d',
        'correct_answer',
        'status',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadre_id',
        'disease_area_id',
        'description_id',
        'question_id',
        'paper_code',
        'section_label',
        'number_of_questions',
        'created_at',
        'updated_at',
        'selected_descriptions',
        'selected_questions'
    ];

    // Define the relationships

    public function cadre()
    {
        return $this->belongsTo(Cadre::class);
    }

    public function diseaseArea()
    {
        return $this->belongsTo(DiseaseArea::class);
    }

    public function description()
    {
        return $this->belongsTo(Description::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'section_questions');
    }

    // public function question()
    // {
    //     return $this->belongsTo(Question::class);
    // }
}

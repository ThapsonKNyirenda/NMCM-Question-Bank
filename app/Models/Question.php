<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
use App\Traits\Searchable;

class Question extends Model
{
    use HasFactory;
    use Searchable;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'cadre_id',
        'nursing_process_id',
        'taxonomy_level_id',
        'syllabus',
        'description_id',
        'title',
        'choice_a',
        'choice_b',
        'choice_c',
        'choice_d',
        'correct_answer',
        'status'       
    ];

    protected $searchable = [
        'uuid',
        'cadre_id',
        'nursing_process_id',
        'taxonomy_level_id',
        'syllabus',
        'description_id',
        'title',
        'choice_a',
        'choice_b',
        'choice_c',
        'choice_d',
        'correct_answer',
        'status'    
    ];

    public function description(){
        return $this->belongsTo(Description::class);
    }

    public function cadre()
    {
        return $this->belongsTo(Cadre::class);
    }

    public function nursingProcess()
    {
        return $this->belongsTo(NursingProcess::class);
    }

    public function taxonomyLevel()
{
    return $this->belongsTo(TaxonomyLevel::class);
}

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_questions');
    }

    
    // public function sections()
    // {
    //     return $this->hasMany(Section::class);
    // }
}
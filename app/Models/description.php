<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
use App\Traits\Searchable;

class description extends Model
{
    use HasFactory;
    use Searchable;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'cadre_id',
        'nursing_process_id',
        'disease_area_id',
        'taxonomy_level_id',
        'description'        
    ];

    public array $searchable = [
        'uuid',
        'cadre_id',
        'nursing_process_id',
        'disease_area_id',
        'taxonomy_level_id',
        'description'  
    ];
}
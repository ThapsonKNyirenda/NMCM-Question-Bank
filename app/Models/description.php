<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
use App\Traits\Searchable;

class Description extends Model
{
    use HasFactory;
    use Searchable;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'disease_area_id',
        'description'        
    ];

    public array $searchable = [
        'uuid',
        'disease_area_id',
        'description'  
    ];

    

    public function diseaseArea()
    {
        return $this->belongsTo(DiseaseArea::class);
    }


    
}
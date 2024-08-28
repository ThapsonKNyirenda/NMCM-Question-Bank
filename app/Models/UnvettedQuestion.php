<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnvettedQuestion extends Model
{
    use HasFactory;
    use Searchable;
    use HasUuid;

    
    protected $fillable = [
        
    ];

    public array $searchable = [
        
    ];

    
}
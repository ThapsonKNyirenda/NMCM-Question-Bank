<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
use App\Traits\Searchable;

class Cadre extends Model
{
    use HasFactory;
    use Searchable;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'name'
    ]; 
    
}
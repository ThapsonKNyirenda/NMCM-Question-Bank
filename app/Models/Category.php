<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'name',
        'description'
    ];

    public array $searchable = [
        'name',
        'description'
    ];

}

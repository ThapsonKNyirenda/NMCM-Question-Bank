<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailTemplateFolder extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'description',
        'is_system_template'
    ];

    protected $casts = [
        'is_system_template' => 'boolean'
    ];

    protected $attributes = [
        'is_system_template' => false
    ];

    public function emailTemplates(): HasMany
    {
        return $this->hasMany( EmailTemplate::class );
    }
}

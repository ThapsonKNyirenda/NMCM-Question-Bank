<?php

namespace App\Models;

use App\Enums\EmailTemplateModule;
use App\Traits\HasUuid;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use HasFactory;
    use HasUuid;
    use Searchable;
    use SoftDeletes;


    protected $fillable = [
        'uuid',
        'email_template_folder_id',
        'module',
        'name',
        'email_subject',
        'reply_to',
        'message',
        'is_system_template'
    ];

    public array $searchable = [
        'module',
        'name',
        'email_subject',
        'reply_to',
        'message'
    ];

    protected $casts = [
        'module' => EmailTemplateModule::class,
        'is_system_template' => 'boolean'
    ];

    protected $attributes = [
        'is_system_template' => false,
    ];

    public function emailTemplateFolder(): BelongsTo
    {
        return $this->belongsTo(EmailTemplateFolder::class);
    }

    public function scopeFilterByFolder(Builder $query, $folderId){
        $query->when($folderId, function (Builder $qry, $folderId){
            $qry->where('email_template_folder_id', $folderId);
        });
    }
}

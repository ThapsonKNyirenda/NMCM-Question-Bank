<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'name',
        'team_leader_id',
        'email_alias',
        'description'
    ];

    public array $searchable = [
        'name',
        'email_alias',
        'description'
    ];

    /**
     * Get the team's team leader
     */
    public function teamLeader(): BelongsTo
    {
        return $this->belongsTo( User::class,'team_leader_id', 'id' )->withDefault();
    }

    /**
     * The users that belong to the team.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'team_members', 'team_id', 'user_id')
            ->using(TeamMember::class)
            ->withTimestamps();
    }
}

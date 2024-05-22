<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasBooleanStatus;
use App\Traits\HasPhoto;
use App\Traits\HasRoles;
use App\Traits\HasUuid;
use App\Traits\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuid, HasBooleanStatus, HasPhoto, HasRoles, Searchable, TwoFactorAuthenticatable ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'signature',
        'status',
        'photo',
        'last_login_at',
        'last_login_ip_address'
    ];

    protected $appends = [
        'photo_url',
        'last_login_after'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => true,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean'
        ];
    }

    public array $searchable = [
        'name',
        'email',
    ];

    public function lastLoginAfter(): Attribute
    {
        return Attribute::make(
            get:  fn($val) => !is_null($this->last_login_at) ? Carbon::parse($this->last_login_at)->diffForHumans() : null
        );
    }


    /**
     * The teams that a user belong to.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_members','user_id', 'team_id')
            ->using(TeamMember::class)
            ->withTimestamps();
    }

    /**
     * @param Builder $query
     * @param int|null $roleId
     * @return void
     */
    public function scopeFilterByRole( Builder $query, ?int $roleId): void
    {
        $query->when( $roleId , function($query, $roleId){
            return $query->whereRelation('roles', 'roles.id', $roleId);
        });
    }
}

<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use PHPUnit\Framework\Attributes\Ticket;

class Tag extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
    ];

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function customers(): MorphToMany
    {
        return $this->morphedByMany(Customer::class, 'taggable');
    }

    /**
     * Get all of the contacts that are assigned this tag.
     */
    public function contacts(): MorphToMany
    {
        return $this->morphedByMany(Contact::class, 'taggable');
    }

    /**
     * Get all of the tickets that are assigned this tag.\
     */
    public function tickets(): MorphToMany
    {
        return $this->morphedByMany(Ticket::class, 'taggable');
    }
}

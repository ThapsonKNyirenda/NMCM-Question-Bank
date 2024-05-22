<?php

namespace App\Models;

use App\Enums\CustomerType;
use App\Traits\HasFilterByStatus;
use App\Traits\HasFilterByTag;
use App\Traits\HasPhoto;
use App\Traits\HasUuid;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use Searchable;
    use HasUuid;
    use SoftDeletes;
    use HasPhoto;
    use HasFilterByTag;
    use HasFilterByStatus;

    protected $fillable = [
        'name',
        'tax_id',
        'photo',
        'customer_type',
        'contact_id',
        'billing_contact_id',
        'technical_contact_id',
        'administrative_contact_id',
        'description',
        'support_pin',
        'customer_number',
        'is_active'
    ];

    protected $casts = [
        'customer_type' => CustomerType::class,
        'is_active' => 'boolean'
    ];

    protected $appends = [
        'photo_url'
    ];

    protected $attributes = [
        'is_active' => true,
        'customer_type' => CustomerType::Company
    ];


    /**
     * Get all the contacts for the  customer
     */
    public function contacts(): MorphMany
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    /**
     * Get the main contact for the customer
     */
    public function mainContact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    /**
     * Get the billing contact for the customer
     */
    public function billingContact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'billing_contact_id', 'id');
    }

    /**
     * Get the technical contact for the customer
     */
    public function technicalContact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'technical_contact_id', 'id');
    }

    /**
     * Get the administrative contact for the customer
     */
    public function administrativeContact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'administrative_contact_id', 'id');
    }

    /**
     * Get all of the tags for the customer.
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function contracts(){
        return $this->hasMany(Contract::class);
    }

}

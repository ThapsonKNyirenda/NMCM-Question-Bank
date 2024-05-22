<?php

namespace App\Models;

use App\Traits\HasFilterByStatus;
use App\Traits\HasFilterByTag;
use App\Traits\HasPhoto;
use App\Traits\HasUuid;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Contact extends Model
{
    use HasFactory;
    use HasUuid;
    use HasPhoto;
    use Searchable;
    use HasFilterByTag;
    use HasFilterByStatus;

    protected $fillable = [
        'uuid',
        'contactable_id',
        'contactable_type',
        'name',
        'title',
        'email_address',
        'phone',
        'mobile_phone',
        'postal_address',
        'physical_address',
        'fax',
        'country',
        'village',
        'district',
        'traditional_authority',
        'website',
        'facebook_link',
        'twitter_link',
        'photo',
        'is_active',
        'description'
    ];

    public array $searchable = [
        'name',
        'title',
        'email_address',
        'phone',
        'mobile_phone',
        'postal_address'
    ];

    protected $appends = [
        'photo_url'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $attributes = [
        'is_active' => true
    ];

    public function contactable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get all of the tags for the contact.
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Scope the query to include only contacts whose title is not 'Customer Main Contact'
     */
    public function scopeNotMainContact(Builder $query): void
    {
        $query->where('title' , '<>', 'Customer Main Contact');
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeWithCustomer(Builder $query): void
    {
        $query->with([ 'contactable' => function ( MorphTo $morphTo ){
            $morphTo->constrain([
                Customer::class => function($qry){
                    $qry->select('id','uuid','name','billing_contact_id','administrative_contact_id','technical_contact_id');
                }
            ]);
        }]);
    }

    /**
     * scope the query to include on contact associated with the specifies customer
     *
     * @param Builder $query
     * @param string|null $customerId
     * @return void
     */
    public function  scopeFilterByCustomer(Builder $query, ?string $customerId): void
    {
        $query->when( $customerId , function (Builder $query, string $customerId){
            $query->whereHasMorph(
                'contactable',
                Customer::class,
                function (Builder $qry) use ($customerId){
                    $qry->where('customers.id', $customerId);
                }
            );
        });
    }

}

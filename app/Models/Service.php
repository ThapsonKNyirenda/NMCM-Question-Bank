<?php

namespace App\Models;

use App\Enums\BillingCycle;
use App\Traits\HasUuid;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use Searchable;
    use HasUuid;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'service_category_id',
        'is_billable',
        'billing_cycle',
    ];

    public array $searchable = [
        'name',
        'billing_cycle'
    ];

    protected $casts = [
        'billing_cycle' => BillingCycle::class,

    ];

    protected $attributes = [
        'billing_cycle' => BillingCycle::class,
        'is_billable' => true
    ];

    protected $appends = [
        'is_billable_yes_no'
    ];
    public function isBillableYesNo(): Attribute
    {
        return Attribute::make(
            get:fn ($value) => $this->is_billable ? 'Yes' : 'No'
        );
    }
    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class)->withDefault();
    }

    public function contracts(){
        return $this->hasMany(Contract::class);
    }
}

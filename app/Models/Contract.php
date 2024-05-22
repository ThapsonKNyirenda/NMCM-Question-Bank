<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'customer_id',
        'service_id',
        'start_date',
        'end_date',
        'billing_cycle',
        'charge_rate',
        'status'

    ];
    public array $searchable = [
        'service',
        'status',
        'billing_cycle'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withDefault();
    }

    public function service()
    {
        return $this->belongsTo(Service::class)->withDefault();
    }
}

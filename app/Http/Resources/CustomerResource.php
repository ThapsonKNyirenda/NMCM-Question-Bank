<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid ,
            'name' => $this->name,
            'tax_id' => $this->tax_id,
            'photo' => $this->photo,
            'customer_type' => $this->customer_type,
            'contact_id' => $this->contact_id,
            'billing_contact_id' => $this->billing_contact_id,
            'technical_contact_id' => $this->technical_contact_id,
            'administrative_contact_id' => $this->administrative_contact_id,
            'description' => $this->description,
            'support_pin' => $this->support_pin,
            'customer_number' => $this->customer_number,
            'is_active' => $this->is_active
        ];
    }
}

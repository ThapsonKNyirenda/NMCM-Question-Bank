<?php

namespace App\Traits;

use App\Models\Employee;
use App\Models\WorkLocation;
use Illuminate\Database\Eloquent\Model;

trait Contactable
{
    /**
     * @param Employee|WorkLocation $model
     * @param array $contact
     *
     * @return void
     */
    public function updateContacts(Employee|WorkLocation $model, array $contact): void
    {
        $model->contact->update( $contact );
    }

    /**
     * @param Employee|WorkLocation $model
     * @param array $contact
     *
     * @return Model
     */
    public function createContact(Employee|WorkLocation $model, array $contact): Model
    {
        return $model->contact()->create( $contact );
    }

}

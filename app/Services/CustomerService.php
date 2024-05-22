<?php

namespace App\Services;

use App\Enums\ContactType;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Tag;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomerService
{
    /**
     * @throws Exception
     */
    public function createCustomer(array $validatedData ): Customer
    {
        $path  = $validatedData['file'] ? 'storage/'.$validatedData['file']->store('uploads') : null;

        $customer = Customer::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'is_active' => $validatedData['is_active'],
            'tax_id' => $validatedData['tax_id'],
            'photo'     => $path
        ]);

        $this->addPinAndMainContact( $customer, $validatedData, $path );

        $this->syncCustomerTags( $customer, $validatedData['tags'],);

        return $customer;

    }

    public function updateCustomer(Customer $customer, array $validatedData ): void
    {
        if ($customer->mainContact()->exists()){
            $customer->mainContact()->update(
                $validatedData['contact']
            );
        }else{
            $contact = $this->addCustomerMainContact($customer, $validatedData, $customer->photo);

            $customer->update([
                ...collect($validatedData)->except(['contact', 'tags'])->all(),
                'contact_id' => $contact->id
            ]);
        }

        $this->syncCustomerTags( $customer, $validatedData['tags'],);
    }

    /**
     * @throws Exception
     */
    public function addPinAndMainContact(Customer $customer, array $validatedData, ?string $path): void
    {
        //create and get the main contact
        $contact = $this->addCustomerMainContact($customer, $validatedData, $path);

        $customer->update([
            'support_pin' => $this->generateSupportPin($customer->name),
            'contact_id' => $contact->id
        ]);
    }

    /**
     * Generate the support PIN
     *
     * @param string $string
     * @return string
     * @throws Exception
     */
    public function generateSupportPin(string $string): string
    {
        $supportPin  = Str::take( str_acronym( $string) , 5 ). random_int(1000, 9999);
        if ( ! Customer::where( 'support_pin', $supportPin )->exists()){
            return $supportPin;
        }

        return  $this->generateSupportPin($string);
    }

    /**
     * @param $customer
     * @param array $validatedData
     * @param string|null $path
     * @return Contact
     */
    public function addCustomerMainContact($customer, array $validatedData, ?string $path): Contact
    {
        return $customer->contacts()->create([
            'name' => $validatedData['name'],
            'title' => 'Customer Main Contact',
            'email_address' => $validatedData['contact']['email_address'],
            'phone' => $validatedData['contact']['phone'],
            'postal_address' => $validatedData['contact']['postal_address'],
            'physical_address' => $validatedData['contact']['physical_address'],
            'country' => $validatedData['contact']['country'],
            'district' => $validatedData['contact']['district'],
            'website' => $validatedData['contact']['website'],
            'photo' => $path,
        ]);
    }

    /**
     * create contact for the specified customer
     *
     * @param Customer $customer
     * @param array $validatedData
     * @return void
     */
    public function createCustomerContact(Customer $customer, array $validatedData): void
    {
        $contact = $this->createContact($customer, $validatedData);

        $this->updatedCustomerBillingTechnicalAdminContact($validatedData['contact_type'], $customer, $contact);

        $this->syncCustomerTags( $contact, $validatedData['tags'] ?? []);
    }


    /**
     * Create model's (i.e. Customer) contact
     *
     * @param Customer $model
     * @param array $validatedData
     * @return Contact|Model
     */
    public function createContact(Customer $model, array $validatedData): Contact | Model
    {
        $path  = $validatedData['file'] ? 'storage/'.$validatedData['file']->store('uploads') : null;

        return $model->contacts()->create([
            'name' => $validatedData['name'],
            'title' => $validatedData['title'],
            'email_address' => $validatedData['email_address'],
            'phone' => $validatedData['phone'],
            'mobile_phone' => $validatedData['mobile_phone'],
            'postal_address' => $validatedData['postal_address'],
            'physical_address' => $validatedData['physical_address'] ?? null,
            'country' => $validatedData['country'] ?? null,
            'district' => $validatedData['district'] ?? null,
            'website' => $validatedData['website'] ?? null,
            'photo' => $path,
        ]);
    }

    /**
     * @param Customer $customer
     * @param Contact $contact
     * @param array $validatedData
     * @return void
     */
    public function updateCustomerContacts(Customer $customer, Contact $contact, array $validatedData): void
    {
        $contact->update(
            collect($validatedData)->except(['tags', 'contact_type'])->all()
        );

        $this->updatedCustomerBillingTechnicalAdminContact($validatedData['contact_type'], $customer, $contact);

        $this->syncCustomerTags( $contact, $validatedData['tags'] ?? []);
    }

    /**
     * @param Customer|Contact $model
     * @param array $tags
     * @return void
     */
    public function syncCustomerTags(Customer|Contact $model, array $tags): void
    {
        //Create an array for upserting the tags
        $tagsUpsert = collect($tags)->map(function ( string $tag, int $key){
            return [ 'name' => $tag ];
        })->all();

        Tag::upsert( $tagsUpsert, uniqueBy: ['name'] );

        $tags = Tag::whereIn('name', $tags)->pluck('id');

        $model->tags()->sync($tags);
    }

    /**
     * @param $contact_type
     * @param Customer $customer
     * @param Model|Contact $contact
     * @return void
     */
    public function updatedCustomerBillingTechnicalAdminContact($contact_type, Customer $customer, Model|Contact $contact): void
    {
        if ($contact_type === ContactType::Billing->value) {
            $customer->update([
                'billing_contact_id' => $contact->id
            ]);
        }

        if ($contact_type === ContactType::Administrative->value) {
            $customer->update([
                'administrative_contact_id' => $contact->id
            ]);
        }

        if ($contact_type === ContactType::Technical->value) {
            $customer->update([
                'technical_contact_id' => $contact->id
            ]);
        }
    }
}

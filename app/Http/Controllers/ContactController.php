<?php

namespace App\Http\Controllers;

use App\Enums\ContactType;
use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Models\Contact;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function __construct(private CustomerService $customerService )
    {
         Inertia::share('activeMenu', 'Customer Management');
         $this->authorizeResource( Contact ::class, 'contact');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Contact/Index',[
            'contacts' => Contact::select('id','contactable_id', 'contactable_type', 'uuid','name', 'title','phone', 'mobile_phone','email_address','postal_address','is_active', 'photo')
                ->whenSearch($request->input('search'))
                ->filterByTags( $request->input('tags') )
                ->filterByStatus( $request->is_active )
                ->filterByCustomer($request->input('customer_id'))
                ->withCustomer()
                ->orderBy('id','desc')
                ->paginate($request->per_page)
                ->withQueryString(),
            'contactTypes' => ContactType::array(),
            'filters' => $request->only(['search','is_active', 'customer_id', 'contact_type']) ?? []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Contact/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContactStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ContactStoreRequest $request): RedirectResponse
    {
        $customer = Customer::find($request->customer_id);
        $this->customerService->createCustomerContact($customer, $request->validated());

        return redirect()->route('contacts.index')->with('success', 'Contact successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Contact $contact
     * @return Response
     */
    public function edit(Contact $contact): Response
    {
        return Inertia::render('Contact/Edit', [
            'contact' => $contact->loadMorph('contactable', [
                Customer::class
            ])->load('tags:id,name')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ContactUpdateRequest $request
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function update( ContactUpdateRequest $request, Contact $contact): RedirectResponse
    {
        $customer = Customer::findOrFail($request->customer_id);

        $this->customerService->updateCustomerContacts($customer, $contact, $request->validated());

       $contact->update($request->validated());
       return redirect()->route('contacts.index')->with('success', 'Contact successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}

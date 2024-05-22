<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerContactStoreRequest;
use App\Http\Requests\CustomerContactUpdateRequest;
use App\Models\Contact;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class CustomerContactController extends Controller
{

    public function __construct( private CustomerService $customerService)
    {
        Inertia::share('activeMenu', 'Customer Management');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Customer $customer): Response
    {
        Gate::authorize('viewAny', Contact::class);

        return Inertia::render('CustomerContact/Index', [
            'contacts' => $customer->contacts()
                ->with('tags:id,name')
                ->notMainContact()
                ->whenSearch($request->input('search'), ['name', 'title'])
                ->paginate($request->per_page)
                ->withQueryString(),
            'customer' => $customer->only('id','uuid', 'name', 'billing_contact_id', 'technical_contact_id', 'administrative_contact_id'),
            'filters' => $request->only(['search', 'is_active']) ?? []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Customer $customer)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerContactStoreRequest $request, Customer $customer): RedirectResponse
    {
        $this->customerService->createCustomerContact($customer, $request->validated());

        return redirect()->back()->with('success', 'Contact successfully assigned to the customer');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer, Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer, Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerContactUpdateRequest $request, Customer $customer, Contact $contact)
    {
        $this->customerService->updateCustomerContacts($customer, $contact, $request->validated());

        return redirect()->back()->with('success', 'Customer contact successfully updates');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer, Contact $contact)
    {
        //
    }
}

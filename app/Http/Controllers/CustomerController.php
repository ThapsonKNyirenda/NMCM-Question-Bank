<?php

namespace App\Http\Controllers;

use App\Enums\CustomerType;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    public function __construct( private CustomerService $customerService)
    {
         Inertia::share('activeMenu', 'Customer Management');
         $this->authorizeResource( Customer ::class, 'customer');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Customer/Index', [
            'customers' => Customer::select('id', 'uuid', 'name', 'contact_id', 'photo', 'is_active')
                ->with('mainContact')
                ->filterByTags( $request->input('tags') )
                ->filterByStatus( $request->is_active )
                ->whenSearch($request->input('search'), ['name'])
                ->paginate($request->per_page)
                ->withQueryString(),
            'customerTypes' => CustomerType::array(),
            'filters' => $request->only(['search', 'tags', 'customer_type']) ?? []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Customer/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerStoreRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(CustomerStoreRequest $request): RedirectResponse
    {
        $customer = $this->customerService->createCustomer( $request->validated() );
        return redirect()
            ->route('customers.contacts.index', ['customer' => $customer])
            ->with('success', 'Customer details successfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customer $customer
     * @return Response
     */
    public function edit(Customer $customer)
    {
        return Inertia::render('Customer/Edit', [
            'customer' => $customer
                ->load(
                    'tags:id,name',
                    'mainContact:id,uuid,phone,email_address,postal_address,physical_address,country,district,website,photo'
                )
                ->only(['uuid', 'name', 'contact_id','tax_id', 'photo_url', 'is_active', 'tags', 'description', 'mainContact'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerUpdateRequest $request
     * @param Customer $customer
     * @return RedirectResponse
     */
    public function update(CustomerUpdateRequest $request, Customer $customer): RedirectResponse
    {
       $this->customerService->updateCustomer( $customer, $request->validated() );
       return redirect()
           ->route('customers.contacts.index', ['customer'=> $customer])
           ->with('success', 'Customer details successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}

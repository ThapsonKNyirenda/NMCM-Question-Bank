<?php

namespace App\Http\Controllers;
use App\Http\Requests\ContractStoreRequest;
use App\Http\Requests\ContractUpdateRequest;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    public function __construct()
    {
         Inertia::share('activeMenu', 'Contract');
        //$this->authorizeResource( Channel ::class, 'channel');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        return Inertia::render('Contract/Index',[
            'contracts' => Contract::whenSearch($request->input('search'))
                ->with('customer')
                ->with('service')
                ->paginate($request->per_page)
                ->withQueryString(),
            'filters' => $request->only(['search', 'per_page']) ?? []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(): Response
    {
        $customers = Customer::all();
        $services = Service::all();

        return Inertia::render('Contract/Create', [
            'customers' => $customers,
            'services' => $services,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(ContractStoreRequest $request)
    {
        //
        Contract::create($request->validated());
        return redirect()->route('contracts.index')->with('success', 'Contract successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param Contract $contract
     * @return Response
     */


    public function edit(Contract $contract)
    {
        //
        $customers = Customer::all();
        $services = Service::all();

        return Inertia::render('Contract/Edit', [
            'contract' => $contract->toArray(),
            'customers' => $customers,
            'services' => $services
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param ContractUpdateRequest $request
     * @param Contract $contract
     * @return RedirectResponse
     */

    // public function update(ChannelUpdateRequest $request, Channel $channel): RedirectResponse
    // {
    //    $channel->update($request->validated());
    //    return redirect()->route('channels.index')->with('success', ' successfully updated');
    // }

    public function update(ContractUpdateRequest $request, Contract $contract)
    {
        //
        $contract->update($request->validated());
        return redirect()->route('contracts.index')->with('success', ' successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract): RedirectResponse
    {
        $contract->delete();

        return redirect()->back()->with('success', 'contract successfully deleted');
    }
}

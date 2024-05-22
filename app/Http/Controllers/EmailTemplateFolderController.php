<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplateFolder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailTemplateFolderController extends Controller
{
    public function __construct()
    {
         Inertia::share('activeMenu', '');
         $this->authorizeResource( EmailTemplateFolder ::class, '');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return Inertia::render('EmailTemplateFolder/Index',[
            'emailTemplateFolders' => EmailTemplateFolder::whenSearch($request->input('search'), [])
                ->paginate(8)
                ->withQueryString(),
            'filters' => $request->only(['search']) ?? []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('EmailTemplateFolder/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        EmailTemplateFolder::create($request->validated());
        return redirect()->route('.index')->with('success', ' successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailTemplateFolder $emailTemplateFolder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmailTemplateFolder  $emailTemplateFolder
     * @return Response
     */
    public function edit(EmailTemplateFolder $emailTemplateFolder)
    {
        return Inertia::render('EmailTemplateFolder/Edit', [
            'emailTemplateFolder' => $emailTemplateFolder
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmailTemplateFolder  $emailTemplateFolder
     * @return RedirectResponse
     */
    public function update(Request $request, EmailTemplateFolder $emailTemplateFolder)
    {
       $emailTemplateFolder->update($request->validated());
       return redirect()->route('.index')->with('success', ' successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailTemplateFolder $emailTemplateFolder)
    {
        //
    }
}

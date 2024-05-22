<?php

namespace App\Http\Controllers;

use App\Enums\EmailTemplateModule;
use App\Http\Requests\EmailTemplateRequest;
use App\Models\EmailTemplate;
use App\Models\EmailTemplateFolder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailTemplateController extends Controller
{
    public function __construct()
    {
         Inertia::share('activeMenu', 'Customization');
         $this->authorizeResource( EmailTemplate ::class, 'email_template');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('EmailTemplate/Index',[
            'emailTemplates' => EmailTemplate::whenSearch($request->input('search'))
                ->filterByFolder($request->email_template_folder_id)
                ->with('emailTemplateFolder:id,name')
                ->paginate($request->per_page)
                ->withQueryString(),
            'emailTemplateModules' => EmailTemplateModule::array(),
            'emailTemplateFolders' => EmailTemplateFolder::all('id', 'name'),
            'filters' => $request->only(['search', 'per_page', 'email_template_folder_id']) ?? []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('EmailTemplate/Create',[
            'emailTemplateModules' => EmailTemplateModule::array(),
            'emailTemplateFolders' => EmailTemplateFolder::all('id', 'name'),
            'placeholders' => config('email-templates.placeholders')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmailTemplateRequest $request
     * @return RedirectResponse
     */
    public function store(EmailTemplateRequest $request): RedirectResponse
    {
        EmailTemplate::create($request->validated());
        return redirect()
            ->route('email-templates.index')
            ->with('success', 'Email template successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailTemplate $emailTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EmailTemplate $emailTemplate
     * @return Response
     */
    public function edit(EmailTemplate $emailTemplate): Response
    {
        return Inertia::render('EmailTemplate/Edit', [
            'emailTemplate' => $emailTemplate->only(
                'uuid',
                'name',
                'module',
                'email_subject',
                'email_template_folder_id',
                'reply_to',
                'message',
                'is_system_template'
            ),
            'emailTemplateModules' => EmailTemplateModule::array(),
            'emailTemplateFolders' => EmailTemplateFolder::all('id', 'name'),
            'placeholders' => config('email-templates.placeholders')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmailTemplateRequest $request
     * @param EmailTemplate $emailTemplate
     * @return RedirectResponse
     */
    public function update(EmailTemplateRequest $request, EmailTemplate $emailTemplate): RedirectResponse
    {
       $emailTemplate->update($request->validated());
       return redirect()
           ->route('email-templates.index')
           ->with('success', 'Template was successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailTemplate $emailTemplate): RedirectResponse
    {

        $emailTemplate->delete();

        return redirect()
            ->back()
            ->with('success', 'Template was successfully deleted');
    }
}

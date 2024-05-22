<?php

namespace App\Http\Controllers;

use App\Enums\EmailTemplateModule;
use Illuminate\Http\Request;

class EmailTemplateModuleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, EmailTemplateModule $emailTemplateModule)
    {
        //
    }
}

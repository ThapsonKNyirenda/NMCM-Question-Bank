<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomerContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\EmailTemplateModuleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionRoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSecurityController;
use App\Http\Controllers\ProfileSignatureController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\UploadContactPhotoController;
use App\Http\Controllers\UploadCustomerPhotoController;
use App\Http\Controllers\UploadUserPhotoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\ChannelController;
use Illuminate\Foundation\Application;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\QuestionsController; // Add this line to import the QuestionsController
use App\Http\Controllers\UnvettedQuestionController;
use App\Http\Controllers\VettedQuestionController;
use App\Http\Controllers\QuestionBankController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    Inertia::share('activeMenu', 'Dashboard');
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/user_created', function (){

    return new \App\Mail\UserCreatedMailable(request()->user());
});

Route::middleware('auth')->group(function () {

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/users/{user}/photo', UploadUserPhotoController::class)->name('users.photo.upload');
    Route::post('/customers/{customer}/photo', UploadCustomerPhotoController::class)->name('customers.photo.upload');
    Route::post('/contacts/{contact}/photo', UploadContactPhotoController::class)->name('customers.contacts.photo.upload');


    Route::prefix('profile')->group(function () {
        Route::get('/signature', [ProfileSignatureController::class, 'edit'])->name('profile.signature.edit');
        Route::patch('/signature', [ProfileSignatureController::class, 'update'])->name('profile.signature.update');
        Route::delete('/signature', [ProfileSignatureController::class, 'destroy'])->name('profile.signature.destroy');
        Route::get('/signature/show', [ProfileSignatureController::class, 'how'])->name('profile.signature.show');
    });

    Route::get('email-templates/{email_template_module}/modules', EmailTemplateModuleController::class)->name('email-templates.modules.index');

    Route::singleton('profile', ProfileController::class);
    Route::singleton('profile-security', ProfileSecurityController::class);

    Route::resource('roles.permissions', RolePermissionController::class)->only(['create', 'tore']);
    Route::resource('permissions.roles', PermissionRoleController::class)->only(['create', 'tore']);
    Route::resource('users.permissions', UserPermissionController::class)->only(['create', 'tore']);
    Route::resource('users.roles', UserRoleController::class)->only(['create', 'tore']);
    Route::resource('customers.contacts', CustomerContactController::class)->only(['index', 'tore', 'update']);
    Route::resource('teams.users', TeamMemberController::class)->only(['index','store','destroy']);

    Route::resources([
        'roles' => RoleController::class,
        'users' => UserController::class,
        'permissions' => PermissionController::class,
        'contacts' => ContactController::class,
        'customers' => CustomerController::class,
        'categories'=> CategoryController::class,
        'channels'=>ChannelController::class,
        'teams'=> TeamController::class,
        'contracts'=> ContractController::class,
        'email-templates' => EmailTemplateController::class,
        'questions' => QuestionController::class,
        'unvettedquestions' => UnvettedQuestionController::class,
        'vettedquestions' => VettedQuestionController::class,
        'questionbank' => QuestionBankController::class,
       
    ]);

});

require __DIR__.'/auth.php';
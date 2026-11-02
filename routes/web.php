<?php

use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\DomainAdminController;
use App\Controllers\Admin\EtablissementAdminController;
use App\Controllers\Admin\FiliereAdminController;
use App\Controllers\Admin\QuizAdminController;
use App\Controllers\Admin\SerieAdminController;
use App\Controllers\Web\AdminAuthController;
use App\Controllers\Web\RegistrationController;
use App\Controllers\Web\StudentAuthController;
use App\Controllers\Web\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Mon Orientation CI
|--------------------------------------------------------------------------
*/

// Public Welcome & Documentation Route
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::view('/documentation-api', 'api.documentation')->name('api.documentation');
Route::get('/admin/connexion', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/connexion', [AdminAuthController::class, 'authenticate'])->name('admin.login.store');
Route::post('/admin/deconnexion', [AdminAuthController::class, 'logout'])
    ->middleware(['auth', 'admin'])
    ->name('admin.logout');

// Authentification utilisateur
Route::get('/inscription', [RegistrationController::class, 'create'])->name('register');
Route::post('/inscription', [RegistrationController::class, 'store'])->name('register.store');
Route::get('/connexion', [StudentAuthController::class, 'login'])->name('login');
Route::post('/connexion', [StudentAuthController::class, 'authenticate'])->name('login.store');
Route::post('/deconnexion', [StudentAuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('espace')->name('student.')->middleware('auth')->group(function () {
    Route::get('/', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/filieres', [StudentController::class, 'programs'])->name('programs');
    Route::get('/filieres/{filiere}', [StudentController::class, 'program'])->name('programs.show');
    Route::get('/etablissements', [StudentController::class, 'institutions'])->name('institutions');
    Route::get('/etablissements/{institution}', [StudentController::class, 'institution'])->name('institutions.show');
    Route::get('/orientation', [StudentController::class, 'orientation'])->name('orientation');
    Route::post('/orientation', [StudentController::class, 'submitOrientation'])->name('orientation.store');
    Route::get('/resultats', [StudentController::class, 'results'])->name('results');
    Route::get('/resultats/{result}', [StudentController::class, 'result'])->name('results.show');
});

// Admin Dashboard & Management Routes (Laravel Blade + Bootstrap 5)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Filières (Programs) Management
    Route::resource('filieres', FiliereAdminController::class);

    // Établissements (Institutions) Management
    Route::resource('etablissements', EtablissementAdminController::class);

    // BAC Series Management
    Route::get('/series', [SerieAdminController::class, 'index'])->name('series.index');
    Route::post('/series', [SerieAdminController::class, 'store'])->name('series.store');
    Route::put('/series/{id}', [SerieAdminController::class, 'update'])->name('series.update');
    Route::delete('/series/{id}', [SerieAdminController::class, 'destroy'])->name('series.destroy');

    // Domains Management
    Route::get('/domains', [DomainAdminController::class, 'index'])->name('domains.index');
    Route::post('/domains', [DomainAdminController::class, 'store'])->name('domains.store');
    Route::put('/domains/{id}', [DomainAdminController::class, 'update'])->name('domains.update');
    Route::delete('/domains/{id}', [DomainAdminController::class, 'destroy'])->name('domains.destroy');

    // Quiz & Recommendation Rules Management
    Route::get('/quiz', [QuizAdminController::class, 'index'])->name('quiz.index');
    Route::post('/quiz', [QuizAdminController::class, 'store'])->name('quiz.store');
    Route::delete('/quiz/{id}', [QuizAdminController::class, 'destroy'])->name('quiz.destroy');
});

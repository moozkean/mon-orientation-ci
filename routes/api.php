<?php

use App\Controllers\Api\AuthController;
use App\Controllers\Api\ComparisonController;
use App\Controllers\Api\EtablissementController;
use App\Controllers\Api\FavoriteController;
use App\Controllers\Api\FiliereController;
use App\Controllers\Api\MetadataController;
use App\Controllers\Api\OrientationController;
use App\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Mon Orientation CI
|--------------------------------------------------------------------------
| Plateforme d'Orientation Académique Post-BAC en République de Côte d'Ivoire.
*/

// Reference Metadata
Route::get('/metadata', [MetadataController::class, 'getMetadata']);

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/admin-register', [AuthController::class, 'registerAdmin'])->middleware('throttle:5,1');
    Route::post('/refresh', [AuthController::class, 'refreshToken']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

    // Protected Auth Routes
    Route::middleware([JwtMiddleware::class])->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        Route::put('/grades', [AuthController::class, 'updateGrades']);
    });
});

// Programs (Filières) Catalog Routes
Route::prefix('filieres')->group(function () {
    Route::get('/', [FiliereController::class, 'index']);
    Route::get('/featured', [FiliereController::class, 'featured']);
    Route::get('/{idOrSlug}', [FiliereController::class, 'show']);
});

// Institutions (Établissements) Routes
Route::prefix('etablissements')->group(function () {
    Route::get('/', [EtablissementController::class, 'index']);
    Route::get('/top-universities', [EtablissementController::class, 'topUniversities']);
    Route::get('/{id}', [EtablissementController::class, 'show']);
});

// Academic Orientation & Recommendation Engine Routes
Route::prefix('orientation')->group(function () {
    Route::get('/questions', [OrientationController::class, 'getQuestions']);
    Route::post('/evaluate', [OrientationController::class, 'submitQuiz']); // Guest / Public evaluation

    Route::middleware([JwtMiddleware::class])->group(function () {
        Route::post('/submit', [OrientationController::class, 'submitQuiz']);
        Route::get('/history', [OrientationController::class, 'getHistory']);
        Route::get('/results/{id}', [OrientationController::class, 'getResult']);
    });
});

// Program Comparison Route (Side-by-side comparison of 2 or 3 programs)
Route::post('/comparison', [ComparisonController::class, 'compare']);

// Favorites Routes (Protected)
Route::middleware([JwtMiddleware::class])->prefix('favorites')->group(function () {
    Route::get('/', [FavoriteController::class, 'index']);
    Route::post('/toggle', [FavoriteController::class, 'toggle']);
    Route::get('/check', [FavoriteController::class, 'check']);
});

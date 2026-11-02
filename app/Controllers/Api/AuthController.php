<?php

namespace App\Controllers\Api;

use App\Models\User;
use App\Services\JwtService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController
{
    protected JwtService $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * Register a new student.
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'city_id' => 'nullable|exists:cities,id',
            'bac_serie_id' => 'nullable|exists:bac_series,id',
            'bac_year' => 'nullable|integer|min:2000|max:2030',
            'bac_mention' => 'nullable|in:Passable,Assez-Bien,Bien,Très-Bien',
            'academic_grades' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation des données.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'city_id' => $request->city_id,
            'bac_serie_id' => $request->bac_serie_id,
            'bac_year' => $request->bac_year ?? 2026,
            'bac_mention' => $request->bac_mention,
            'academic_grades' => $request->academic_grades,
        ]);

        $user->load(['city', 'bacSerie']);

        $token = $this->jwtService->generateToken($user);
        $refreshToken = $this->jwtService->generateRefreshToken($user);

        return response()->json([
            'success' => true,
            'message' => 'Compte créé avec succès. Bienvenue sur Mon Orientation CI !',
            'data' => [
                'user' => $user,
                'token' => $token,
                'refresh_token' => $refreshToken,
                'token_type' => 'Bearer',
            ],
        ], 201);
    }

    /**
     * Login student or admin.
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required_without:matricule|string',
            'matricule' => 'required_without:login|string',
            'account_type' => 'nullable|in:student,admin',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Identifiants requis.',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->filled('matricule')) {
            $user = User::with(['city', 'bacSerie'])
                ->where('matricule', $request->matricule)
                ->where('role', 'admin')
                ->first();
        } else {
            $login = $request->login;
            $user = User::with(['city', 'bacSerie'])
                ->where(fn ($query) => $query->where('email', $login)->orWhere('phone', $login))
                ->first();
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email/Téléphone ou mot de passe incorrect.',
            ], 401);
        }

        if ($request->input('account_type') === 'admin' && $user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Ce compte ne possède pas les droits administrateur.',
            ], 403);
        }

        if ($request->input('account_type') === 'student' && $user->role !== 'student') {
            return response()->json([
                'success' => false,
                'message' => 'Utilisez l’accès administrateur pour ce compte.',
            ], 403);
        }

        $token = $this->jwtService->generateToken($user);
        $refreshToken = $this->jwtService->generateRefreshToken($user);

        return response()->json([
            'success' => true,
            'message' => 'Connexion réussie.',
            'data' => [
                'user' => $user,
                'token' => $token,
                'refresh_token' => $refreshToken,
                'token_type' => 'Bearer',
            ],
        ]);
    }

    /**
     * Register an administrator using a locally configured invitation code.
     */
    public function registerAdmin(Request $request): JsonResponse
    {
        $invitationCode = config('auth.admin_registration_code');
        if (!is_string($invitationCode) || $invitationCode === '') {
            return response()->json([
                'success' => false,
                'message' => 'Les inscriptions administrateur sont désactivées. Configurez ADMIN_REGISTRATION_CODE sur le serveur.',
            ], 503);
        }

        if (!is_string($request->input('invitation_code'))
            || !hash_equals($invitationCode, $request->input('invitation_code'))) {
            return response()->json([
                'success' => false,
                'message' => 'Le code d’invitation administrateur est invalide.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'matricule' => 'required|string|alpha_dash|max:32|unique:users,matricule',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
            'invitation_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation des données.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'matricule' => strtoupper($request->matricule),
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        $token = $this->jwtService->generateToken($user);
        $refreshToken = $this->jwtService->generateRefreshToken($user);

        return response()->json([
            'success' => true,
            'message' => 'Compte administrateur créé.',
            'data' => [
                'user' => $user,
                'token' => $token,
                'refresh_token' => $refreshToken,
                'token_type' => 'Bearer',
            ],
        ], 201);
    }

    /**
     * Get authenticated user profile.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->load(['city', 'bacSerie']);

        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }

    /**
     * Refresh JWT token.
     */
    public function refreshToken(Request $request): JsonResponse
    {
        $refreshToken = $request->input('refresh_token');
        if (!$refreshToken) {
            return response()->json([
                'success' => false,
                'message' => 'Jeton de rafraîchissement requis.',
            ], 400);
        }

        $payload = $this->jwtService->validateToken($refreshToken);
        if (!$payload || ($payload['type'] ?? '') !== 'refresh') {
            return response()->json([
                'success' => false,
                'message' => 'Jeton de rafraîchissement invalide ou expiré.',
            ], 401);
        }

        $user = User::find($payload['sub']);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur introuvable.',
            ], 404);
        }

        $newToken = $this->jwtService->generateToken($user);
        $newRefreshToken = $this->jwtService->generateRefreshToken($user);

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $newToken,
                'refresh_token' => $newRefreshToken,
                'token_type' => 'Bearer',
            ],
        ]);
    }

    /**
     * Update student profile.
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $user->id,
            'city_id' => 'nullable|exists:cities,id',
            'bac_serie_id' => 'nullable|exists:bac_series,id',
            'bac_year' => 'nullable|integer',
            'bac_mention' => 'nullable|in:Passable,Assez-Bien,Bien,Très-Bien',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user->update($request->only([
            'name',
            'phone',
            'city_id',
            'bac_serie_id',
            'bac_year',
            'bac_mention',
        ]));

        $user->load(['city', 'bacSerie']);

        return response()->json([
            'success' => true,
            'message' => 'Profil mis à jour avec succès.',
            'data' => $user,
        ]);
    }

    /**
     * Update academic grades.
     */
    public function updateGrades(Request $request): JsonResponse
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'academic_grades' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Notes invalides.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user->academic_grades = $request->academic_grades;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Notes académiques enregistrées.',
            'data' => $user->academic_grades,
        ]);
    }

    /**
     * Forgot password simulation/request.
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Cette adresse email n\'est pas enregistrée.',
            ], 404);
        }

        // In a production app, send email with reset link or SMS OTP (popular in Côte d'Ivoire with Orange/MTN/Moov)
        return response()->json([
            'success' => true,
            'message' => 'Un lien de réinitialisation sécurisé a été envoyé à votre adresse email.',
        ]);
    }
}

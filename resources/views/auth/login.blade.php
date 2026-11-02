<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion étudiant — Mon Orientation CI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --ci-green-dark: #07352f;
            --ci-green: #087f5b;
            --ci-green-light: #10a778;
            --ci-orange: #ff8200;
            --ci-orange-hover: #e06c00;
            --ci-bg-light: #f4f7f6;
            --ci-border: #dbe5e0;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--ci-green-dark) 0%, #0a7060 55%, var(--ci-bg-light) 55%);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #1f2d29;
        }

        .auth-card {
            border: 0;
            border-radius: 24px;
            box-shadow: 0 24px 60px rgba(7, 53, 47, 0.18);
            background: #ffffff;
            overflow: hidden;
        }

        .auth-side {
            background: linear-gradient(150deg, var(--ci-green), var(--ci-green-light));
            color: #ffffff;
            position: relative;
        }

        .auth-side::after {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            border: 60px solid rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            bottom: -80px;
            right: -80px;
            pointer-events: none;
        }

        .brand-badge {
            background: var(--ci-orange);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            padding: 6px 14px;
            border-radius: 8px;
            display: inline-block;
        }

        .btn-auth {
            background: var(--ci-orange);
            border: 0;
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 12px;
            transition: all 0.2s ease-in-out;
        }

        .btn-auth:hover {
            background: var(--ci-orange-hover);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(255, 130, 0, 0.35);
        }

        .btn-auth:active {
            transform: translateY(0);
        }

        .form-control, .form-select {
            border: 1.5px solid var(--ci-border);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--ci-green);
            box-shadow: 0 0 0 0.25rem rgba(8, 127, 91, 0.18);
        }

        .form-check-input:checked {
            background-color: var(--ci-green);
            border-color: var(--ci-green);
        }

        .link-ci {
            color: var(--ci-green);
            font-weight: 700;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .link-ci:hover {
            color: #05543c;
            text-decoration: underline;
        }

        .back-link {
            color: #5d716a;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .back-link:hover {
            color: var(--ci-green);
        }

        @media (max-width: 991.98px) {
            body {
                background: linear-gradient(180deg, var(--ci-green-dark) 0%, #0a7060 100%);
            }
            .auth-side {
                padding: 2.5rem 1.5rem !important;
            }
        }
    </style>
</head>
<body class="d-flex align-items-center py-4 py-lg-5">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="card auth-card shadow-lg">
                <div class="row g-0">
                    <!-- Volet visuel gauche (Vert CI) -->
                    <div class="col-lg-5 auth-side p-4 p-md-5 d-flex flex-column justify-content-between">
                        <div>
                            <span class="brand-badge shadow-sm">CI</span>
                            <h1 class="h3 fw-bold mt-4 mb-3 text-white">Votre avenir commence ici.</h1>
                            <p class="text-white-50 mb-4">
                                Découvrez les filières, explorez les établissements d'enseignement supérieur et révélez votre profil d'orientation.
                            </p>
                        </div>
                        <div class="mt-4 pt-3 d-flex align-items-center justify-content-between">
                            <span class="text-white-50 small">Plateforme Nationale d'Orientation</span>
                            <i class="bi bi-mortarboard display-2 opacity-25"></i>
                        </div>
                    </div>

                    <!-- Volet formulaire droite (Blanc) -->
                    <div class="col-lg-7 p-4 p-md-5 bg-white">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="{{ route('welcome') }}" class="back-link">
                                <i class="bi bi-arrow-left me-1"></i>Accueil
                            </a>
                            <span class="badge bg-light text-muted border px-2 py-1 small">Espace Étudiant</span>
                        </div>

                        <h2 class="h3 fw-bold mt-2 mb-1">Connexion étudiant</h2>
                        <p class="text-muted small mb-4">Retrouvez votre espace personnel et vos recommandations.</p>

                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm rounded-3 py-2 px-3 mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle-fill text-danger me-2 fs-5"></i>
                                    <div>{{ $errors->first() }}</div>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="login" class="form-label fw-semibold small">E-mail ou téléphone</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 12px 0 0 12px; border-color: var(--ci-border);">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input id="login" name="login" value="{{ old('login') }}" class="form-control form-control-lg border-start-0 ps-0" placeholder="nom@exemple.ci ou 0700000000" style="border-radius: 0 12px 12px 0;" required autofocus>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold small">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 12px 0 0 12px; border-color: var(--ci-border);">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input id="password" name="password" type="password" class="form-control form-control-lg border-start-0 ps-0" placeholder="••••••••" style="border-radius: 0 12px 12px 0;" required>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label text-muted small" for="remember">Rester connecté</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-auth w-100 py-3 shadow-sm">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                            </button>
                        </form>

                        <div class="text-center mt-4 pt-2 border-top">
                            <p class="text-muted small mb-0 mt-3">
                                Nouveau sur la plateforme ? <a href="{{ route('register') }}" class="link-ci">Créer un compte</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

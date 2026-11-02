<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte utilisateur — Mon Orientation CI</title>
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
            width: 320px;
            height: 320px;
            border: 65px solid rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            bottom: -90px;
            right: -90px;
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
            padding: 0.7rem 0.95rem;
            font-size: 0.95rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--ci-green);
            box-shadow: 0 0 0 0.25rem rgba(8, 127, 91, 0.18);
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

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 1rem;
            font-size: 0.92rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .feature-item i {
            font-size: 1.15rem;
            color: #ffe066;
            margin-top: 2px;
            flex-shrink: 0;
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
        <div class="col-lg-11 col-xl-10">
            <div class="card auth-card shadow-lg">
                <div class="row g-0">
                    <!-- Volet visuel gauche (Vert CI) -->
                    <div class="col-lg-4 auth-side p-4 p-md-5 d-flex flex-column justify-content-between">
                        <div>
                            <span class="brand-badge shadow-sm">CI</span>
                            <h1 class="h3 fw-bold mt-4 mb-3 text-white">Votre avenir commence ici.</h1>
                            <p class="text-white-50 mb-4">
                                Rejoignez la plateforme nationale pour enregistrer votre profil et accéder à tous les outils d'orientation universitaire.
                            </p>

                            <div class="pt-2 d-none d-lg-block">
                                <div class="feature-item">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Orientation personnalisée selon votre série du BAC</span>
                                </div>
                                <div class="feature-item">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Accès complet aux filières et universités homologuées</span>
                                </div>
                                <div class="feature-item">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Simulateur d’admissibilité et scores de concordance</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 d-flex align-items-center justify-content-between">
                            <span class="text-white-50 small">Plateforme Nationale d'Orientation</span>
                            <i class="bi bi-mortarboard display-2 opacity-25"></i>
                        </div>
                    </div>

                    <!-- Volet formulaire droite (Blanc) -->
                    <div class="col-lg-8 p-4 p-md-5 bg-white">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="{{ route('welcome') }}" class="back-link">
                                <i class="bi bi-arrow-left me-1"></i>Accueil
                            </a>
                            <span class="badge bg-light text-muted border px-2 py-1 small">Espace Étudiant</span>
                        </div>

                        <h2 class="h3 fw-bold mt-2 mb-1">Créer votre compte utilisateur</h2>
                        <p class="text-muted small mb-4">Inscrivez-vous pour enregistrer votre profil et utiliser les outils d'orientation.</p>

                        @if (session('success'))
                            <div class="alert alert-success border-0 shadow-sm rounded-3 py-2 px-3 mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                    <div>{{ session('success') }}</div>
                                </div>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm rounded-3 py-2 px-3 mb-4">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-exclamation-triangle-fill text-danger me-2 fs-5 mt-1"></i>
                                    <div>
                                        <strong class="d-block mb-1">Veuillez corriger les informations suivantes :</strong>
                                        <ul class="mb-0 ps-3 small">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register.store') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold small">Nom complet <span class="text-danger">*</span></label>
                                    <input id="name" name="name" type="text" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Ex. : Kouassi Jean-Yves" required maxlength="255">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold small">Adresse e-mail <span class="text-danger">*</span></label>
                                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="nom@exemple.ci" required maxlength="255">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-semibold small">Téléphone</label>
                                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" maxlength="20" placeholder="Ex. : 0700000000">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="city_id" class="form-label fw-semibold small">Ville</label>
                                    <select id="city_id" name="city_id" class="form-select @error('city_id') is-invalid @enderror">
                                        <option value="">Choisir une ville</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" @selected((string) old('city_id') === (string) $city->id)>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold small">Mot de passe <span class="text-danger">*</span></label>
                                    <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required minlength="6">
                                    <div class="form-text small text-muted">Au moins 6 caractères.</div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-semibold small">Confirmer le mot de passe <span class="text-danger">*</span></label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="••••••••" required minlength="6">
                                </div>

                                <div class="col-md-4">
                                    <label for="bac_serie_id" class="form-label fw-semibold small">Série du BAC</label>
                                    <select id="bac_serie_id" name="bac_serie_id" class="form-select @error('bac_serie_id') is-invalid @enderror">
                                        <option value="">Choisir une série</option>
                                        @foreach ($series as $serie)
                                            <option value="{{ $serie->id }}" @selected((string) old('bac_serie_id') === (string) $serie->id)>{{ $serie->code }} — {{ $serie->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('bac_serie_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="bac_year" class="form-label fw-semibold small">Année du BAC</label>
                                    <input id="bac_year" name="bac_year" type="number" min="2000" max="2030" value="{{ old('bac_year', $defaultYear) }}" class="form-control @error('bac_year') is-invalid @enderror" placeholder="{{ $defaultYear }}">
                                    @error('bac_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="bac_mention" class="form-label fw-semibold small">Mention</label>
                                    <select id="bac_mention" name="bac_mention" class="form-select @error('bac_mention') is-invalid @enderror">
                                        <option value="">Choisir une mention</option>
                                        @foreach ($mentions as $mention)
                                            <option value="{{ $mention }}" @selected(old('bac_mention') === $mention)>{{ $mention }}</option>
                                        @endforeach
                                    </select>
                                    @error('bac_mention')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-auth w-100 mt-4 py-3 shadow-sm">
                                <i class="bi bi-person-plus-fill me-2"></i>Créer mon compte
                            </button>
                        </form>

                        <div class="text-center mt-4 pt-2 border-top">
                            <p class="text-muted small mb-0 mt-3">
                                Vous avez déjà un compte ? <a href="{{ route('login') }}" class="link-ci">Se connecter</a>
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

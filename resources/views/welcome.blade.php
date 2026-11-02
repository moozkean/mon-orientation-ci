<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Orientation CI - Plateforme Nationale d'Orientation Post-BAC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --ci-orange: #FF8200;
            --ci-green: #009A44;
            --ci-dark: #0f172a;
        }
        .hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            padding: 90px 0;
            position: relative;
            overflow: hidden;
        }
        .ci-stripe {
            height: 6px;
            background: linear-gradient(90deg, #FF8200 0%, #FF8200 33.3%, #FFFFFF 33.3%, #FFFFFF 66.6%, #009A44 66.6%, #009A44 100%);
        }
        .btn-ci-orange {
            background-color: var(--ci-orange);
            color: white;
            font-weight: 600;
            padding: 12px 28px;
            border-radius: 50px;
            border: none;
        }
        .btn-ci-orange:hover {
            background-color: #e06c00;
            color: white;
        }
        .btn-ci-green {
            background-color: var(--ci-green);
            color: white;
            font-weight: 600;
            padding: 12px 28px;
            border-radius: 50px;
            border: none;
        }
        .btn-ci-green:hover {
            background-color: #007c37;
            color: white;
        }
    </style>
</head>
<body>
    <div class="ci-stripe"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#">
                <span class="badge bg-warning text-dark px-2 py-1">CI</span> Mon Orientation CI
            </a>
            <div class="ms-auto d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="bi bi-box-arrow-in-right"></i> Connexion
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="bi bi-person-plus-fill"></i> Créer un compte
                </a>
                <a href="{{ route('api.documentation') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="bi bi-filetype-json"></i> Documentation API
                </a>
                <a href="{{ route('admin.login') }}" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold">
                    <i class="bi bi-speedometer2"></i> Panel Admin
                </a>
            </div>
        </div>
    </nav>

    <header class="hero text-center">
        <div class="container">
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill mb-3">
                <i class="bi bi-mortarboard-fill"></i> Ministère de l'Enseignement Supérieur et de la Recherche Scientifique
            </span>
            <h1 class="display-4 fw-bold mb-3">Trouvez votre voie d'excellence après le BAC</h1>
            <p class="lead text-light opacity-75 max-w-2xl mx-auto mb-4" style="max-width: 700px;">
                La plateforme intelligente d'orientation académique dédiée aux nouveaux bacheliers de Côte d'Ivoire. Découvrez les filières, comparez les universités publiques et écoles privées, et calculez votre taux de compatibilité selon votre série du BAC.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('register') }}" class="btn btn-ci-orange shadow-lg">
                    <i class="bi bi-person-plus-fill me-1"></i> S'inscrire gratuitement
                </a>
                <a href="{{ route('admin.login') }}" class="btn btn-ci-orange shadow-lg">
                    <i class="bi bi-gear-fill me-1"></i> Accéder au Panel Admin
                </a>
                <a href="{{ url('/api/metadata') }}" class="btn btn-ci-green shadow-lg">
                    <i class="bi bi-lightning-charge-fill me-1"></i> Tester l'API (métadonnées)
                </a>
            </div>
        </div>
    </header>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h3 class="fw-bold">Architecture de la Solution</h3>
                <p class="text-muted">Système complet Full-Stack : Laravel 12 REST API + Flutter Mobile + MySQL</p>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 h-100 rounded-4">
                        <div class="fs-1 text-primary mb-3"><i class="bi bi-phone"></i></div>
                        <h5 class="fw-bold">Application Mobile Flutter</h5>
                        <p class="text-muted small">Design Material 3 aux couleurs nationales, gestion d'état Riverpod, questionnaire interactif, comparateur et favoris.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 h-100 rounded-4">
                        <div class="fs-1 text-success mb-3"><i class="bi bi-cpu"></i></div>
                        <h5 class="fw-bold">Moteur de Recommandation</h5>
                        <p class="text-muted small">Algorithme multi-critères prenant en compte les séries ivoiriennes (A1, A2, C, D, E, F, G), les moyennes pondérées et le profil RIASEC.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 h-100 rounded-4">
                        <div class="fs-1 text-warning mb-3"><i class="bi bi-shield-lock"></i></div>
                        <h5 class="fw-bold">Backend Sécurisé & Admin</h5>
                        <p class="text-muted small">API REST PHP 8.3 / Laravel avec JWT Tokens, tableaux de bord analytiques et gestion administrative des filières et établissements.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

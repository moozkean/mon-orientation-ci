<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration') - Mon Orientation CI</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --ci-orange: #FF8200;
            --ci-green: #009A44;
            --ci-dark: #0f172a;
            --ci-card: #ffffff;
            --ci-border: #e2e8f0;
            --ci-light-bg: #f8fafc;
        }
        body {
            background-color: var(--ci-light-bg);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #1e293b;
        }
        .sidebar {
            width: 270px;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            color: #e2e8f0;
            box-shadow: 4px 0 20px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }
        .sidebar-brand {
            padding: 22px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .ci-badge-flag {
            width: 14px;
            height: 38px;
            border-radius: 4px;
            background: linear-gradient(to bottom, #FF8200 33%, #FFFFFF 33%, #FFFFFF 66%, #009A44 66%);
            display: inline-block;
        }
        .sidebar-brand h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1.1rem;
            color: #ffffff;
            letter-spacing: -0.5px;
        }
        .sidebar-brand span {
            color: var(--ci-orange);
            font-weight: 800;
        }
        .nav-section-title {
            padding: 16px 20px 8px;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #64748b;
            font-weight: 700;
        }
        .sidebar .nav-link {
            color: #94a3b8;
            padding: 11px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            border-radius: 8px;
            margin: 3px 12px;
            transition: all 0.2s ease;
        }
        .sidebar .nav-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(3px);
        }
        .sidebar .nav-link.active {
            color: #ffffff;
            background: linear-gradient(90deg, var(--ci-orange) 0%, #e06c00 100%);
            box-shadow: 0 4px 12px rgba(255, 130, 0, 0.35);
        }
        .main-content {
            margin-left: 270px;
            padding: 25px 35px 50px;
            min-height: 100vh;
        }
        .top-navbar {
            background: #ffffff;
            border-bottom: 1px solid var(--ci-border);
            padding: 14px 28px;
            border-radius: 12px;
            margin-bottom: 28px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .stat-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            transition: transform 0.2s, box-shadow 0.2s;
            overflow: hidden;
            position: relative;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        }
        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .bg-orange-soft { background-color: rgba(255, 130, 0, 0.12); color: var(--ci-orange); }
        .bg-green-soft { background-color: rgba(0, 154, 68, 0.12); color: var(--ci-green); }
        .bg-blue-soft { background-color: rgba(14, 165, 233, 0.12); color: #0284c7; }
        .bg-purple-soft { background-color: rgba(139, 92, 246, 0.12); color: #7c3aed; }
        .badge-degree {
            padding: 5px 10px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.78rem;
        }
        .btn-ci-orange {
            background-color: var(--ci-orange);
            color: #ffffff;
            border: none;
            font-weight: 600;
        }
        .btn-ci-orange:hover {
            background-color: #e06c00;
            color: #ffffff;
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <span class="ci-badge-flag"></span>
            <div>
                <h5>Mon Orientation <span>CI</span></h5>
                <small class="text-white-50" style="font-size: 0.75rem;">Plateforme MESRS Côte d'Ivoire</small>
            </div>
        </div>

        <nav class="mt-3">
            <div class="nav-section-title">Navigation Principale</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Tableau de bord
            </a>

            <div class="nav-section-title">Catalogue Académique</div>
            <a href="{{ route('admin.filieres.index') }}" class="nav-link {{ request()->routeIs('admin.filieres.*') ? 'active' : '' }}">
                <i class="bi bi-mortarboard-fill"></i> Filières & Formations
            </a>
            <a href="{{ route('admin.etablissements.index') }}" class="nav-link {{ request()->routeIs('admin.etablissements.*') ? 'active' : '' }}">
                <i class="bi bi-buildings-fill"></i> Universités & Écoles
            </a>
            <a href="{{ route('admin.domains.index') }}" class="nav-link {{ request()->routeIs('admin.domains.*') ? 'active' : '' }}">
                <i class="bi bi-bookmarks-fill"></i> Domaines d'Études
            </a>

            <div class="nav-section-title">Système d'Orientation</div>
            <a href="{{ route('admin.series.index') }}" class="nav-link {{ request()->routeIs('admin.series.*') ? 'active' : '' }}">
                <i class="bi bi-card-checklist"></i> Séries du BAC CI
            </a>
            <a href="{{ route('admin.quiz.index') }}" class="nav-link {{ request()->routeIs('admin.quiz.*') ? 'active' : '' }}">
                <i class="bi bi-question-circle-fill"></i> Quiz & Recommandations
            </a>

            <div class="nav-section-title">Ressources & API</div>
            <a href="/public/swagger.json" target="_blank" class="nav-link">
                <i class="bi bi-code-slash"></i> Spécification API Swagger
            </a>
            <a href="/" target="_blank" class="nav-link">
                <i class="bi bi-globe"></i> Portail Public
            </a>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <main class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <h4 class="mb-0 fw-bold">@yield('page_title', 'Tableau de bord')</h4>
                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                    <i class="bi bi-check-circle-fill me-1"></i> Système Opérationnel
                </span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-light rounded-circle p-2" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><h6 class="dropdown-header">Notifications</h6></li>
                        <li><a class="dropdown-item small" href="#">Nouveau test d'orientation complété</a></li>
                        <li><a class="dropdown-item small" href="#">Mise à jour filière INP-HB effectuée</a></li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 border-start ps-3">
                    <div class="rounded-circle bg-orange-soft p-2 text-center" style="width: 38px; height: 38px;">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div>
                        <div class="fw-semibold small">Administrateur MESRS</div>
                        <div class="text-muted" style="font-size: 0.75rem;">admin@orientation.ci</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#073b33">
    <title>@yield('title', 'Mon Orientation CI')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root{--ink:#092d29;--green:#087f5b;--orange:#ff8200;--pale:#edf7f3;--line:#e2ebe7}body{background:#f5f8f7;color:#263936;font-family:"Segoe UI",system-ui,sans-serif}.shell{min-height:100vh}.sidebar{width:270px;background:linear-gradient(175deg,#07352f,#092d29);color:#fff;position:fixed;inset:0 auto 0 0;z-index:1030}.brand{min-height:86px;border-bottom:1px solid rgba(255,255,255,.1)}.student-nav a{color:rgba(255,255,255,.72);text-decoration:none;display:flex;align-items:center;gap:12px;padding:12px 16px;border-radius:12px;margin:5px 14px;transition:.2s}.student-nav a:hover,.student-nav a.active{background:rgba(255,255,255,.1);color:#fff;transform:translateX(3px)}.student-nav i{font-size:1.2rem}.content{margin-left:270px}.topbar{height:86px;background:rgba(255,255,255,.94);border-bottom:1px solid var(--line);position:sticky;top:0;z-index:1020;backdrop-filter:blur(12px)}.main{padding:32px}.hero-card{border:0;border-radius:22px;background:linear-gradient(115deg,#087f5b,#10a778);color:white;overflow:hidden;position:relative}.hero-card:after{content:"";position:absolute;width:260px;height:260px;border:55px solid rgba(255,255,255,.07);border-radius:50%;right:-90px;top:-130px}.metric-card,.surface-card{border:1px solid var(--line);border-radius:18px;background:#fff;box-shadow:0 12px 35px rgba(12,63,51,.055)}.metric-icon{width:48px;height:48px;display:grid;place-items:center;border-radius:14px}.badge-level{background:#fff3e5;color:#aa5500}.btn-orange{background:var(--orange);color:#fff;border:0;font-weight:700}.btn-orange:hover{background:#df7100;color:#fff}.page-enter{animation:enter .45s ease-out}@keyframes enter{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}.program-card{transition:.25s;height:100%}.program-card:hover{transform:translateY(-5px);box-shadow:0 18px 40px rgba(12,63,51,.12)}.progress-ring{height:8px;border-radius:99px}.mobile-menu{display:none}.footer-main{color:#71827e;font-size:.85rem}.type-label{text-transform:capitalize}
        @media(max-width:991.98px){.sidebar{width:100%;height:auto;position:static}.brand{min-height:70px}.student-nav{display:none}.student-nav.open{display:block}.content{margin-left:0}.topbar{height:70px}.mobile-menu{display:block}.main{padding:20px 16px}}
        @yield('styles')
    </style>
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <div class="brand d-flex align-items-center px-4">
            <a href="{{ route('welcome') }}" class="text-white text-decoration-none d-flex align-items-center gap-3">
                <span class="badge text-dark fs-5 rounded-3" style="background:#ff8200">CI</span>
                <span><strong>Mon Orientation</strong><small class="d-block opacity-75">Espace étudiant</small></span>
            </a>
            <button class="btn btn-outline-light ms-auto mobile-menu" type="button" onclick="document.querySelector('.student-nav').classList.toggle('open')"><i class="bi bi-list"></i></button>
        </div>
        <nav class="student-nav py-3">
            <a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i> Tableau de bord</a>
            <a href="{{ route('student.orientation') }}" class="{{ request()->routeIs('student.orientation') ? 'active' : '' }}"><i class="bi bi-signpost-split"></i> Test d’orientation</a>
            <a href="{{ route('student.programs') }}" class="{{ request()->routeIs('student.program*') ? 'active' : '' }}"><i class="bi bi-mortarboard"></i> Toutes les filières</a>
            <a href="{{ route('student.institutions') }}" class="{{ request()->routeIs('student.institution*') ? 'active' : '' }}"><i class="bi bi-buildings"></i> Écoles & universités</a>
            <a href="{{ route('student.results') }}" class="{{ request()->routeIs('student.result*') ? 'active' : '' }}"><i class="bi bi-clock-history"></i> Mes résultats</a>
        </nav>
    </aside>
    <div class="content">
        <header class="topbar d-flex align-items-center px-4 px-lg-5">
            <div><small class="text-uppercase text-muted fw-bold">Espace personnel</small><h1 class="h5 fw-bold mb-0">@yield('heading')</h1></div>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="d-none d-sm-inline text-end"><strong class="d-block">{{ auth()->user()->name }}</strong><small class="text-muted">Étudiant</small></span>
                <span class="rounded-circle d-grid place-items-center bg-success text-white fw-bold" style="width:42px;height:42px">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-light border" title="Déconnexion"><i class="bi bi-box-arrow-right"></i></button></form>
            </div>
        </header>
        <main class="main page-enter">
            @if(session('success'))<div class="alert alert-success border-0 shadow-sm"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>@endif
            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>

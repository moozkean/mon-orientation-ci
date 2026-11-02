@extends('student.layout')
@section('title','Tableau de bord - Mon Orientation CI')
@section('heading','Tableau de bord')
@section('content')
<div class="hero-card p-4 p-lg-5 mb-4">
    <div class="position-relative" style="z-index:1">
        <span class="badge bg-white text-success mb-3">Bonjour {{ strtok($user->name,' ') }}</span>
        <h2 class="fw-bold mb-2">Construisez un parcours qui vous ressemble.</h2>
        <p class="opacity-75 mb-4">Explorez les filières, comparez les établissements et laissez le test d’orientation affiner vos choix.</p>
        <a href="{{ route('student.orientation') }}" class="btn btn-orange px-4 py-2"><i class="bi bi-stars me-2"></i>Terminer mon orientation</a>
    </div>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="metric-card p-4 d-flex align-items-center gap-3"><div class="metric-icon bg-success-subtle text-success"><i class="bi bi-mortarboard fs-4"></i></div><div><strong class="fs-3 d-block">{{ $programCount }}</strong><small class="text-muted">Filières disponibles</small></div></div></div>
    <div class="col-md-4"><div class="metric-card p-4 d-flex align-items-center gap-3"><div class="metric-icon bg-warning-subtle text-warning"><i class="bi bi-buildings fs-4"></i></div><div><strong class="fs-3 d-block">{{ $institutionCount }}</strong><small class="text-muted">Établissements</small></div></div></div>
    <div class="col-md-4"><div class="metric-card p-4 d-flex align-items-center gap-3"><div class="metric-icon bg-primary-subtle text-primary"><i class="bi bi-clipboard2-check fs-4"></i></div><div><strong class="fs-3 d-block">{{ $resultCount }}</strong><small class="text-muted">Analyses effectuées</small></div></div></div>
</div>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="d-flex align-items-end mb-3"><div><span class="text-success fw-bold small">À découvrir</span><h3 class="h4 fw-bold mb-0">Filières mises en avant</h3></div><a href="{{ route('student.programs') }}" class="ms-auto text-decoration-none">Voir tout <i class="bi bi-arrow-right"></i></a></div>
        <div class="row g-3">
            @forelse($featuredPrograms as $program)
            <div class="col-md-6"><article class="surface-card program-card p-4"><span class="badge badge-level mb-3">{{ $program->degree_level }}</span><h4 class="h6 fw-bold">{{ $program->name }}</h4><p class="small text-muted mb-3">{{ Str::limit($program->domain->description, 90) }}</p><div class="d-flex justify-content-between align-items-center"><small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $program->duration_years }} ans</small><a href="{{ route('student.programs.show',$program) }}" class="btn btn-sm btn-outline-success rounded-pill">Découvrir</a></div></article></div>
            @empty
            <div class="col-12"><div class="alert alert-light">Aucune donnée filière n’est encore disponible.</div></div>
            @endforelse
        </div>
    </div>
    <div class="col-lg-4"><div class="surface-card p-4 h-100"><h3 class="h5 fw-bold mb-3">Mon profil</h3><div class="mb-3"><small class="text-muted d-block">Série du BAC</small><strong>{{ $user->bacSerie?->code ?? 'Non renseignée' }}</strong></div><div class="mb-3"><small class="text-muted d-block">Ville</small><strong>{{ $user->city?->name ?? 'Non renseignée' }}</strong></div><div class="mb-4"><small class="text-muted d-block">Année</small><strong>{{ $user->bac_year ?? 'Non renseignée' }}</strong></div><hr><h4 class="h6 fw-bold">Dernières analyses</h4>@forelse($results as $result)<a href="{{ route('student.results.show',$result) }}" class="d-block p-3 rounded-3 bg-light text-decoration-none text-dark mb-2"><small class="text-muted d-block">{{ $result->created_at->format('d/m/Y') }}</small><strong>{{ $result->bacSerie->code ?? 'BAC' }} · {{ count($result->recommendations) }} suggestions</strong></a>@empty<p class="text-muted small">Vous n’avez pas encore terminé le test.</p>@endforelse</div></div>
</div>
@endsection

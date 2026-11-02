@extends('layouts.admin')

@section('title', 'Tableau de bord Analytique')
@section('page_title', 'Tableau de bord Analytique')

@section('content')
<!-- KPI Cards Row -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Bacheliers Inscrits</div>
                    <h3 class="fw-bold mt-2 mb-0">{{ number_format($totalStudents) }}</h3>
                    <small class="text-success"><i class="bi bi-arrow-up-short"></i> +14.2% cette semaine</small>
                </div>
                <div class="stat-icon bg-orange-soft">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Filières Référencées</div>
                    <h3 class="fw-bold mt-2 mb-0">{{ $totalPrograms }}</h3>
                    <small class="text-primary"><i class="bi bi-mortarboard"></i> BTS, Licences, Ingénieurs</small>
                </div>
                <div class="stat-icon bg-blue-soft">
                    <i class="bi bi-book-half"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Universités & Écoles</div>
                    <h3 class="fw-bold mt-2 mb-0">{{ $totalInstitutions }}</h3>
                    <small class="text-success"><i class="bi bi-patch-check"></i> Habilitées MESRS / CAMES</small>
                </div>
                <div class="stat-icon bg-green-soft">
                    <i class="bi bi-building"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Tests d'Orientation</div>
                    <h3 class="fw-bold mt-2 mb-0">{{ number_format($totalQuizzesCompleted) }}</h3>
                    <small class="text-purple"><i class="bi bi-stars"></i> Recommandations générées</small>
                </div>
                <div class="stat-icon bg-purple-soft">
                    <i class="bi bi-compass-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <!-- BAC Series Distribution -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Demandes d'Orientation par Série du BAC (Côte d'Ivoire)</h5>
                <span class="badge bg-light text-dark border">Session 2026</span>
            </div>
            <p class="text-muted small">Volume d'élèves et compatibilités calculées selon la série du Baccalauréat ivoirien.</p>
            <div style="height: 300px;">
                <canvas id="seriesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Institutions Breakdown -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Typologie des Établissements</h5>
            </div>
            <p class="text-muted small">Répartition des institutions partenaires en Côte d'Ivoire.</p>
            <div style="height: 250px;" class="d-flex justify-content-center align-items-center">
                <canvas id="institutionsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Data Tables Row -->
<div class="row g-4">
    <!-- Recent Students Registered -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Derniers Nouveaux Bacheliers Inscrits</h5>
                <span class="small text-muted">{{ $recentStudents->count() }} récents</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nom & Prénoms</th>
                            <th>Série BAC</th>
                            <th>Ville</th>
                            <th>Mention</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentStudents as $student)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $student->name }}</div>
                                <small class="text-muted">{{ $student->email }}</small>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary border px-2 py-1">
                                    {{ $student->bacSerie->code ?? 'BAC Non spécifié' }}
                                </span>
                            </td>
                            <td>{{ $student->city->name ?? 'Abidjan' }}</td>
                            <td>
                                <span class="badge bg-warning-subtle text-dark">
                                    {{ $student->bac_mention ?? 'Passable' }}
                                </span>
                            </td>
                            <td class="small text-muted">{{ $student->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Aucun bachelier inscrit pour l'instant.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Featured & Demanded Programs -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Filières Phares & Très Demandées</h5>
                <a href="{{ route('admin.filieres.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="list-group list-group-flush">
                @foreach($featuredPrograms as $program)
                <div class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold text-dark">{{ $program->name }}</div>
                        <small class="text-muted">
                            {{ $program->domain->name ?? 'Technologie' }} • {{ $program->degree_level }} ({{ $program->duration_years }} ans)
                        </small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-success-subtle text-success border px-2 py-1">
                            <i class="bi bi-fire"></i> {{ $program->market_demand_rating }}/5 Demande
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // 1. Series Bar Chart
    const ctxSeries = document.getElementById('seriesChart').getContext('2d');
    new Chart(ctxSeries, {
        type: 'bar',
        data: {
            labels: ['Série C', 'Série D', 'Série A1', 'Série A2', 'Série E', 'Série F4 (BTP)', 'Série G2'],
            datasets: [{
                label: 'Étudiants orientés',
                data: [1420, 3850, 940, 2600, 480, 890, 1650],
                backgroundColor: [
                    '#FF8200',
                    '#009A44',
                    '#0284c7',
                    '#8b5cf6',
                    '#f59e0b',
                    '#10b981',
                    '#6366f1'
                ],
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. Institutions Doughnut Chart
    const ctxInst = document.getElementById('institutionsChart').getContext('2d');
    new Chart(ctxInst, {
        type: 'doughnut',
        data: {
            labels: ['Universités Publiques', 'Grandes Écoles Publiques', 'Privé & Écoles Spécialisées', 'Centres BTS'],
            datasets: [{
                data: [
                    {{ $institutionsByType['universite_publique'] ?? 8 }},
                    {{ $institutionsByType['grande_ecole_publique'] ?? 4 }},
                    {{ $institutionsByType['universite_privee'] + $institutionsByType['grande_ecole_privee'] ?? 14 }},
                    {{ $institutionsByType['centre_bts'] ?? 10 }}
                ],
                backgroundColor: ['#009A44', '#FF8200', '#0284c7', '#8b5cf6'],
                borderWidth: 2,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            },
            cutout: '70%'
        }
    });
</script>
@endsection

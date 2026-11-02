@extends('layouts.admin')

@section('title', 'Gestion des Filières')
@section('page_title', 'Filières & Programmes de Formation')

@section('content')
<div class="card border-0 shadow-sm rounded-4 p-4">
    <!-- Header with Actions and Search -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h5 class="fw-bold mb-1">Catalogue des Filières d'Enseignement Supérieur</h5>
            <p class="text-muted small mb-0">Total : {{ $filieres->total() }} formations répertoriées en Côte d'Ivoire</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.filieres.create') }}" class="btn btn-ci-orange rounded-pill px-4">
                <i class="bi bi-plus-circle me-1"></i> Ajouter une Filière
            </a>
        </div>
    </div>

    <!-- Filters Bar -->
    <form method="GET" action="{{ route('admin.filieres.index') }}" class="row g-2 mb-4 bg-light p-3 rounded-3 border">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Rechercher par nom, code (ex: BTS-IDA)..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="domain_id" class="form-select">
                <option value="">Tous les domaines d'études</option>
                @foreach($domains as $domain)
                    <option value="{{ $domain->id }}" {{ request('domain_id') == $domain->id ? 'selected' : '' }}>
                        {{ $domain->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-secondary w-100">
                <i class="bi bi-funnel"></i> Filtrer
            </button>
            @if(request()->hasAny(['search', 'domain_id']))
                <a href="{{ route('admin.filieres.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i>
                </a>
            @endif
        </div>
    </form>

    <!-- Filieres Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Code & Intitulé</th>
                    <th>Domaine</th>
                    <th>Niveau & Durée</th>
                    <th>Difficulté</th>
                    <th>Séries Requises</th>
                    <th>Établissements</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($filieres as $filiere)
                <tr>
                    <td>
                        <div class="fw-bold">{{ $filiere->name }}</div>
                        <span class="badge bg-secondary-subtle text-secondary border font-monospace">{{ $filiere->code }}</span>
                        @if($filiere->is_featured)
                            <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> Phare</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-primary-subtle text-primary border">
                            {{ $filiere->domain->name ?? 'Général' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-info-subtle text-info-emphasis border">
                            {{ $filiere->degree_level }}
                        </span>
                        <div class="small text-muted">{{ $filiere->duration_years }} ans</div>
                    </td>
                    <td>
                        @php
                            $diffClass = match($filiere->difficulty_level) {
                                'Facile' => 'text-success',
                                'Modéré' => 'text-primary',
                                'Exigeant' => 'text-warning',
                                'Très Exigeant' => 'text-danger',
                                default => 'text-muted'
                            };
                        @endphp
                        <span class="fw-semibold small {{ $diffClass }}">
                            <i class="bi bi-circle-fill" style="font-size: 8px;"></i> {{ $filiere->difficulty_level }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($filiere->series->take(4) as $s)
                                <span class="badge bg-light text-dark border" style="font-size: 0.72rem;">
                                    {{ $s->code }}
                                </span>
                            @endforeach
                            @if($filiere->series->count() > 4)
                                <span class="badge bg-light text-muted border">+{{ $filiere->series->count() - 4 }}</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-dark-subtle text-dark border">
                            <i class="bi bi-building"></i> {{ $filiere->etablissements->count() }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="btn-group">
                            <a href="{{ route('admin.filieres.edit', $filiere->id) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.filieres.destroy', $filiere->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression de cette filière ?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                        Aucune filière trouvée selon les critères sélectionnés.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $filieres->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

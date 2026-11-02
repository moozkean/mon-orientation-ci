@extends('layouts.admin')

@section('title', 'Gestion des Établissements')
@section('page_title', 'Universités & Grandes Écoles de Côte d\'Ivoire')

@section('content')
<div class="card border-0 shadow-sm rounded-4 p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h5 class="fw-bold mb-1">Établissements d'Enseignement Supérieur Agréés</h5>
            <p class="text-muted small mb-0">Total : {{ $etablissements->total() }} institutions publiques, privées et BTS répertoriées</p>
        </div>
        <a href="{{ route('admin.etablissements.create') }}" class="btn btn-ci-orange rounded-pill px-4">
            <i class="bi bi-plus-circle me-1"></i> Ajouter un Établissement
        </a>
    </div>

    <!-- Filters Bar -->
    <form method="GET" action="{{ route('admin.etablissements.index') }}" class="row g-2 mb-4 bg-light p-3 rounded-3 border">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Rechercher par nom, sigle (ex: UFHB, INP-HB)..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="type" class="form-select">
                <option value="">Tous les types</option>
                <option value="universite_publique" {{ request('type') == 'universite_publique' ? 'selected' : '' }}>Université Publique</option>
                <option value="grande_ecole_publique" {{ request('type') == 'grande_ecole_publique' ? 'selected' : '' }}>Grande École Publique</option>
                <option value="universite_privee" {{ request('type') == 'universite_privee' ? 'selected' : '' }}>Université Privée</option>
                <option value="grande_ecole_privee" {{ request('type') == 'grande_ecole_privee' ? 'selected' : '' }}>Grande École Privée</option>
                <option value="centre_bts" {{ request('type') == 'centre_bts' ? 'selected' : '' }}>Centre BTS</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="city_id" class="form-select">
                <option value="">Toutes les villes</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-secondary w-100">
                <i class="bi bi-funnel"></i> Filtrer
            </button>
        </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Sigle & Nom de l'Institution</th>
                    <th>Type</th>
                    <th>Ville</th>
                    <th>Accréditations</th>
                    <th>Filières Associées</th>
                    <th>Contact & Web</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($etablissements as $inst)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-light border p-2 text-center fw-bold text-primary" style="width: 44px; height: 44px;">
                                {{ substr($inst->sigle ?? $inst->name, 0, 3) }}
                            </div>
                            <div>
                                <div class="fw-bold">{{ $inst->sigle ? $inst->sigle . ' - ' : '' }}{{ $inst->name }}</div>
                                <small class="text-muted">Fondé en {{ $inst->established_year ?? 'N/A' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        @php
                            $typeBadge = match($inst->type) {
                                'universite_publique', 'grande_ecole_publique' => 'bg-success-subtle text-success border-success-subtle',
                                'universite_privee', 'grande_ecole_privee' => 'bg-primary-subtle text-primary border-primary-subtle',
                                default => 'bg-secondary-subtle text-secondary border-secondary-subtle'
                            };
                            $typeLabel = match($inst->type) {
                                'universite_publique' => 'Univ. Publique',
                                'grande_ecole_publique' => 'Grande École Publique',
                                'universite_privee' => 'Univ. Privée',
                                'grande_ecole_privee' => 'Grande École Privée',
                                'centre_bts' => 'Centre BTS',
                                default => $inst->type
                            };
                        @endphp
                        <span class="badge border {{ $typeBadge }}">{{ $typeLabel }}</span>
                    </td>
                    <td>
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $inst->city->name ?? 'Abidjan' }}
                    </td>
                    <td>
                        @if($inst->is_accredited_mesrs)
                            <span class="badge bg-success-subtle text-success border me-1" title="Homologué Ministère Enseignement Supérieur CI">
                                <i class="bi bi-shield-check"></i> MESRS
                            </span>
                        @endif
                        @if($inst->is_accredited_cames)
                            <span class="badge bg-info-subtle text-info-emphasis border" title="Accrédité CAMES">
                                <i class="bi bi-patch-check-fill"></i> CAMES
                            </span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            <i class="bi bi-mortarboard me-1"></i> {{ $inst->filieres->count() }} filières
                        </span>
                    </td>
                    <td>
                        @if($inst->website)
                            <a href="{{ $inst->website }}" target="_blank" class="btn btn-sm btn-light border p-1" title="Site Web">
                                <i class="bi bi-link-45deg"></i>
                            </a>
                        @endif
                        @if($inst->email)
                            <a href="mailto:{{ $inst->email }}" class="btn btn-sm btn-light border p-1" title="Email">
                                <i class="bi bi-envelope"></i>
                            </a>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="btn-group">
                            <a href="{{ route('admin.etablissements.edit', $inst->id) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.etablissements.destroy', $inst->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?');" style="display:inline;">
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
                        Aucun établissement trouvé.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $etablissements->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

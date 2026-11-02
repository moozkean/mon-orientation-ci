@extends('layouts.admin')

@section('title', 'Gestion des Séries du BAC')
@section('page_title', 'Séries du Baccalauréat en Côte d\'Ivoire')

@section('content')
<div class="card border-0 shadow-sm rounded-4 p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h5 class="fw-bold mb-1">Configuration des Séries Officielles du Baccalauréat</h5>
            <p class="text-muted small mb-0">Enseignement Général, Technique et Professionnel en République de Côte d'Ivoire</p>
        </div>
        <button class="btn btn-ci-orange rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addSerieModal">
            <i class="bi bi-plus-circle me-1"></i> Ajouter une Série
        </button>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Code Série</th>
                    <th>Intitulé Complet</th>
                    <th>Filière d'Enseignement</th>
                    <th>Matières Clés Evaluées</th>
                    <th>Formations Associées</th>
                    <th>Candidats Inscrits</th>
                </tr>
            </thead>
            <tbody>
                @foreach($series as $s)
                <tr>
                    <td>
                        <span class="badge bg-primary fs-6 px-3 py-2 font-monospace">{{ $s->code }}</span>
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ $s->name }}</div>
                        <small class="text-muted">{{ Str::limit($s->description, 50) }}</small>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">{{ $s->stream }}</span>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            @if(is_array($s->key_subjects))
                                @foreach($s->key_subjects as $subject)
                                    <span class="badge bg-info-subtle text-info-emphasis border" style="font-size: 0.72rem;">
                                        {{ $subject }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-success-subtle text-success border">
                            <i class="bi bi-mortarboard me-1"></i> {{ $s->filieres_count }}
                        </span>
                    </td>
                    <td>
                        <span class="fw-bold text-primary">{{ number_format($s->users_count) }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Add Serie -->
<div class="modal fade" id="addSerieModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.series.store') }}" class="modal-content border-0 shadow">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Nouvelle Série du BAC</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Code Série <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control" placeholder="Ex: C, D, A1, F4..." required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Intitulé de la Série <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Ex: Mathématiques et Sciences Physiques" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Filière / Type d'Enseignement <span class="text-danger">*</span></label>
                    <select name="stream" class="form-select" required>
                        <option value="Enseignement Général">Enseignement Général</option>
                        <option value="Enseignement Technique">Enseignement Technique</option>
                        <option value="Formation Professionnelle">Formation Professionnelle</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Matières Clés (séparées par virgules)</label>
                    <input type="text" name="key_subjects" class="form-control" placeholder="Ex: Mathématiques, Sciences Physiques, SVT">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" rows="2" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-ci-orange rounded-pill px-4">Créer la série</button>
            </div>
        </form>
    </div>
</div>
@endsection

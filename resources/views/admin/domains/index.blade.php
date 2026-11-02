@extends('layouts.admin')

@section('title', 'Domaines d\'Études')
@section('page_title', 'Domaines & Pôles de Formation')

@section('content')
<div class="card border-0 shadow-sm rounded-4 p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h5 class="fw-bold mb-1">Domaines d'Études & Pôles Stratégiques</h5>
            <p class="text-muted small mb-0">Catégorisation des cursus universitaires et filières professionnelles en Côte d'Ivoire</p>
        </div>
        <button class="btn btn-ci-orange rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addDomainModal">
            <i class="bi bi-plus-circle me-1"></i> Ajouter un Domaine
        </button>
    </div>

    <div class="row g-4">
        @foreach($domains as $d)
        <div class="col-md-6 col-lg-4">
            <div class="card border p-3 rounded-3 h-100 position-relative shadow-sm">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="rounded-3 p-3 text-white text-center" style="background-color: {{ $d->color_code ?? '#FF8200' }}; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-{{ $d->icon ?? 'book' }} fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">{{ $d->name }}</h6>
                        <small class="text-muted">{{ $d->filieres_count }} filières actives</small>
                    </div>
                </div>
                <p class="small text-secondary mb-3">{{ $d->description ?? 'Domaine de formation d\'excellence.' }}</p>
                <div class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="badge bg-light text-muted border font-monospace">{{ $d->slug }}</span>
                    <form action="{{ route('admin.domains.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Supprimer ce domaine ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-link text-danger p-0">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Add Domain -->
<div class="modal fade" id="addDomainModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.domains.store') }}" class="modal-content border-0 shadow">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Nouveau Domaine d'Études</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom du Domaine <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Ex: Informatique & Sciences du Numérique" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Icône Bootstrap Icons</label>
                    <input type="text" name="icon" class="form-control" placeholder="Ex: laptop, heart-pulse, building, coin" value="laptop">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Couleur d'accent</label>
                    <input type="color" name="color_code" class="form-control form-control-color w-100" value="#FF8200">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" rows="3" class="form-control" placeholder="Présentation du pôle d'études..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-ci-orange rounded-pill px-4">Enregistrer le domaine</button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', $isEdit ? 'Modifier l\'Établissement' : 'Ajouter un Établissement')
@section('page_title', $isEdit ? 'Modification d\'Établissement' : 'Nouvel Établissement Supérieur')

@section('content')
<div class="card border-0 shadow-sm rounded-4 p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h5 class="fw-bold mb-1">{{ $isEdit ? 'Modifier : ' . $etablissement->name : 'Enregistrer une Université / École' }}</h5>
            <small class="text-muted">Fiche descriptive de l'établissement d'enseignement supérieur en Côte d'Ivoire.</small>
        </div>
        <a href="{{ route('admin.etablissements.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Retour à la liste
        </a>
    </div>

    <form method="POST" action="{{ $isEdit ? route('admin.etablissements.update', $etablissement->id) : route('admin.etablissements.store') }}">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-semibold">Nom Officiel de l'Établissement <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $etablissement->name) }}" required placeholder="Ex: Université Félix Houphouët-Boigny">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Sigle / Abréviation</label>
                <input type="text" name="sigle" class="form-control font-monospace" value="{{ old('sigle', $etablissement->sigle) }}" placeholder="Ex: UFHB, INP-HB, UAO">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Type d'Institution <span class="text-danger">*</span></label>
                <select name="type" class="form-select" required>
                    <option value="universite_publique" {{ old('type', $etablissement->type) == 'universite_publique' ? 'selected' : '' }}>Université Publique</option>
                    <option value="grande_ecole_publique" {{ old('type', $etablissement->type) == 'grande_ecole_publique' ? 'selected' : '' }}>Grande École Publique (ex: INP-HB, ENS)</option>
                    <option value="universite_privee" {{ old('type', $etablissement->type) == 'universite_privee' ? 'selected' : '' }}>Université Privée</option>
                    <option value="grande_ecole_privee" {{ old('type', $etablissement->type) == 'grande_ecole_privee' ? 'selected' : '' }}>Grande École Privée</option>
                    <option value="centre_bts" {{ old('type', $etablissement->type) == 'centre_bts' ? 'selected' : '' }}>Centre de Formation BTS</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Ville du Campus Principal <span class="text-danger">*</span></label>
                <select name="city_id" class="form-select" required>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ old('city_id', $etablissement->city_id) == $city->id ? 'selected' : '' }}>
                            {{ $city->name }} ({{ $city->region }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12">
                <label class="form-label fw-semibold">Adresse Complète</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $etablissement->address) }}" placeholder="Ex: Boulevard de l'Université, Cocody, Abidjan">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Email Officiel</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $etablissement->email) }}" placeholder="contact@ufhb.edu.ci">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Téléphone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $etablissement->phone) }}" placeholder="+225 27 22 44 00 00">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Site Internet Officiel</label>
                <input type="url" name="website" class="form-control" value="{{ old('website', $etablissement->website) }}" placeholder="https://www.univ-fhb.edu.ci">
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Présentation & Historique</label>
                <textarea name="description" rows="4" class="form-control" placeholder="Description institutionnelle, facultés / UFR...">{{ old('description', $etablissement->description) }}</textarea>
            </div>

            <div class="col-md-6">
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="is_accredited_mesrs" value="1" id="mesrs" {{ old('is_accredited_mesrs', $etablissement->is_accredited_mesrs ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="mesrs">Agrément MESRS (Ministère Enseignement Supérieur CI)</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="is_accredited_cames" value="1" id="cames" {{ old('is_accredited_cames', $etablissement->is_accredited_cames ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="cames">Reconnaissance & Diplômes certifiés CAMES</label>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
            <a href="{{ route('admin.etablissements.index') }}" class="btn btn-light px-4">Annuler</a>
            <button type="submit" class="btn btn-ci-orange rounded-pill px-5">
                <i class="bi bi-save me-1"></i> {{ $isEdit ? 'Mettre à jour' : 'Enregistrer' }}
            </button>
        </div>
    </form>
</div>
@endsection

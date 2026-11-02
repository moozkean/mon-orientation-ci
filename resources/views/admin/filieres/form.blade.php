@extends('layouts.admin')

@section('title', $isEdit ? 'Modifier la Filière' : 'Ajouter une Filière')
@section('page_title', $isEdit ? 'Modification de Filière' : 'Nouvelle Filière Académique')

@section('content')
<div class="card border-0 shadow-sm rounded-4 p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h5 class="fw-bold mb-1">{{ $isEdit ? 'Modifier : ' . $filiere->name : 'Créer une Nouvelle Filière' }}</h5>
            <small class="text-muted">Configuration académique pour le système d'orientation post-BAC ivoirien.</small>
        </div>
        <a href="{{ route('admin.filieres.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Retour à la liste
        </a>
    </div>

    <form method="POST" action="{{ $isEdit ? route('admin.filieres.update', $filiere->id) : route('admin.filieres.store') }}">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="row g-3">
            <!-- Program Name -->
            <div class="col-md-8">
                <label class="form-label fw-semibold">Intitulé de la Filière <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $filiere->name) }}" required placeholder="Ex: Licence en Génie Logiciel & Intelligence Artificielle">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Code -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">Code Officiel MESRS <span class="text-danger">*</span></label>
                <input type="text" name="code" class="form-control font-monospace @error('code') is-invalid @enderror" value="{{ old('code', $filiere->code) }}" required placeholder="Ex: LIC-GL-01 ou BTS-IDA">
                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Domain -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">Domaine d'Études <span class="text-danger">*</span></label>
                <select name="domain_id" class="form-select @error('domain_id') is-invalid @enderror" required>
                    <option value="">Sélectionner un domaine</option>
                    @foreach($domains as $domain)
                        <option value="{{ $domain->id }}" {{ old('domain_id', $filiere->domain_id) == $domain->id ? 'selected' : '' }}>
                            {{ $domain->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Degree Level -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">Niveau du Diplôme <span class="text-danger">*</span></label>
                <select name="degree_level" class="form-select @error('degree_level') is-invalid @enderror" required>
                    @foreach(['BTS', 'Licence', 'Master', 'Ingenieur', 'Doctorat'] as $level)
                        <option value="{{ $level }}" {{ old('degree_level', $filiere->degree_level) == $level ? 'selected' : '' }}>
                            {{ $level }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Duration -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">Durée de la Formation (années) <span class="text-danger">*</span></label>
                <input type="number" name="duration_years" class="form-control" value="{{ old('duration_years', $filiere->duration_years ?? 3) }}" min="1" max="10" required>
            </div>

            <!-- Description -->
            <div class="col-12">
                <label class="form-label fw-semibold">Description & Objectifs Pédagogiques <span class="text-danger">*</span></label>
                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required placeholder="Détaillez le programme, les compétences acquises...">{{ old('description', $filiere->description) }}</textarea>
            </div>

            <!-- Admission Requirements -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Conditions d'Accès & Prérequis</label>
                <textarea name="admission_requirements" rows="3" class="form-control" placeholder="Moyenne minimale, matières clés requises au BAC...">{{ old('admission_requirements', $filiere->admission_requirements) }}</textarea>
            </div>

            <!-- Career Opportunities -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Débouchés Métiers (séparés par des virgules)</label>
                @php
                    $careersStr = is_array($filiere->career_opportunities) ? implode(', ', $filiere->career_opportunities) : '';
                @endphp
                <textarea name="career_opportunities" rows="3" class="form-control" placeholder="Ex: Développeur Web, Analyste Cybersécurité, Chef de Projet IT">{{ old('career_opportunities', $careersStr) }}</textarea>
            </div>

            <!-- Difficulty & Market Demand -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">Niveau de Difficulté</label>
                <select name="difficulty_level" class="form-select">
                    @foreach(['Facile', 'Modéré', 'Exigeant', 'Très Exigeant'] as $diff)
                        <option value="{{ $diff }}" {{ old('difficulty_level', $filiere->difficulty_level) == $diff ? 'selected' : '' }}>
                            {{ $diff }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Demande sur le Marché de l'Emploi en CI (1 à 5)</label>
                <input type="number" name="market_demand_rating" class="form-control" value="{{ old('market_demand_rating', $filiere->market_demand_rating ?? 4) }}" min="1" max="5">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Salaire Débutant Estimatif (FCFA/mois)</label>
                <input type="number" name="average_starting_salary_fcfa" class="form-control" value="{{ old('average_starting_salary_fcfa', $filiere->average_starting_salary_fcfa ?? 250000) }}" step="25000" placeholder="Ex: 250000">
            </div>

            <!-- Featured check -->
            <div class="col-12 mt-2">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured" {{ old('is_featured', $filiere->is_featured) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="isFeatured">Mettre en avant cette filière sur l'application mobile (Filière Phare)</label>
                </div>
            </div>

            <!-- BAC Series Selection -->
            <div class="col-md-6 mt-3">
                <label class="form-label fw-bold"><i class="bi bi-card-checklist text-primary"></i> Séries du BAC Compatibles</label>
                <div class="border rounded-3 p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                    @php
                        $selectedSeries = $filiere->series ? $filiere->series->pluck('id')->toArray() : [];
                    @endphp
                    @foreach($series as $s)
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" name="series[]" value="{{ $s->id }}" id="serie_{{ $s->id }}" {{ in_array($s->id, old('series', $selectedSeries)) ? 'checked' : '' }}>
                        <label class="form-check-label small" for="serie_{{ $s->id }}">
                            <span class="badge bg-secondary me-1">{{ $s->code }}</span> {{ $s->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Institutions Selection -->
            <div class="col-md-6 mt-3">
                <label class="form-label fw-bold"><i class="bi bi-buildings text-success"></i> Établissements Habilités en Côte d'Ivoire</label>
                <div class="border rounded-3 p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                    @php
                        $selectedInst = $filiere->etablissements ? $filiere->etablissements->pluck('id')->toArray() : [];
                    @endphp
                    @foreach($institutions as $inst)
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" name="institutions[]" value="{{ $inst->id }}" id="inst_{{ $inst->id }}" {{ in_array($inst->id, old('institutions', $selectedInst)) ? 'checked' : '' }}>
                        <label class="form-check-label small" for="inst_{{ $inst->id }}">
                            <strong>{{ $inst->sigle ?? $inst->name }}</strong> - {{ Str::limit($inst->name, 35) }} ({{ $inst->city->name ?? 'Abidjan' }})
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
            <a href="{{ route('admin.filieres.index') }}" class="btn btn-light px-4">Annuler</a>
            <button type="submit" class="btn btn-ci-orange rounded-pill px-5">
                <i class="bi bi-save me-1"></i> {{ $isEdit ? 'Enregistrer les modifications' : 'Créer la filière' }}
            </button>
        </div>
    </form>
</div>
@endsection

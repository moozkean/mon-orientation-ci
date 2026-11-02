@extends('layouts.admin')

@section('title', 'Moteur d\'Orientation & Quiz')
@section('page_title', 'Configuration du Moteur d\'Orientation & Questionnaire')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Tests Réalisés</div>
                    <h3 class="fw-bold mt-2 mb-0">{{ number_format($totalCompletions) }}</h3>
                    <small class="text-success"><i class="bi bi-cpu-fill"></i> Algorithme actif</small>
                </div>
                <div class="stat-icon bg-purple-soft">
                    <i class="bi bi-patch-question-fill"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Questions Actives</div>
                    <h3 class="fw-bold mt-2 mb-0">{{ $quizzes->count() }}</h3>
                    <small class="text-primary"><i class="bi bi-list-check"></i> RIASEC & Académique</small>
                </div>
                <div class="stat-icon bg-blue-soft">
                    <i class="bi bi-question-diamond-fill"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Taux de Satisfaction</div>
                    <h3 class="fw-bold mt-2 mb-0">96.8%</h3>
                    <small class="text-success"><i class="bi bi-shield-check"></i> Précision MESRS</small>
                </div>
                <div class="stat-icon bg-green-soft">
                    <i class="bi bi-hand-thumbs-up-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Quiz Questions List -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Questions du Questionnaire d'Orientation</h5>
                <button class="btn btn-sm btn-ci-orange rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                    <i class="bi bi-plus"></i> Nouvelle Question
                </button>
            </div>
            <div class="list-group list-group-flush">
                @foreach($quizzes as $quiz)
                <div class="list-group-item px-0 py-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="badge bg-secondary-subtle text-secondary me-2">#{{ $quiz->order_number }}</span>
                            <span class="badge bg-primary-subtle text-primary me-2 font-monospace">{{ $quiz->dimension ?? 'RIASEC' }}</span>
                            <span class="fw-semibold text-dark">{{ $quiz->question_text }}</span>
                        </div>
                        <form action="{{ route('admin.quiz.destroy', $quiz->id) }}" method="POST" onsubmit="return confirm('Supprimer cette question ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-link text-danger p-0 ms-2">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                    @if(is_array($quiz->options))
                    <div class="mt-2 ps-4">
                        <small class="text-muted d-block mb-1">Choix possibles :</small>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($quiz->options as $opt)
                                <span class="badge bg-light text-dark border small">
                                    {{ $opt['text'] ?? $opt }} ({{ $opt['dimension'] ?? '' }})
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Orientation Runs -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3">Dernières Orientations Calculées</h5>
            <div class="list-group list-group-flush">
                @forelse($recentResults as $res)
                <div class="list-group-item px-0 py-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark">{{ $res->user->name ?? 'Candidat Anonyme' }}</span>
                        <span class="badge bg-primary-subtle text-primary">{{ $res->bacSerie->code ?? 'BAC' }}</span>
                    </div>
                    @php
                        $topRec = $res->recommendations[0] ?? null;
                    @endphp
                    @if($topRec)
                    <div class="small text-success fw-semibold">
                        <i class="bi bi-arrow-return-right"></i> Top 1: {{ $topRec['program_name'] ?? 'Filière recommandée' }}
                        <span class="badge bg-success ms-1">{{ $topRec['compatibility_score'] ?? 90 }}% compatibilité</span>
                    </div>
                    @endif
                    <small class="text-muted d-block mt-1">{{ $res->created_at->diffForHumans() }}</small>
                </div>
                @empty
                <div class="text-center py-4 text-muted small">Aucun calcul récent disponible.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Question -->
<div class="modal fade" id="addQuestionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('admin.quiz.store') }}" class="modal-content border-0 shadow">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Ajouter une Question d'Orientation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Texte de la Question <span class="text-danger">*</span></label>
                    <textarea name="question_text" rows="2" class="form-control" placeholder="Ex: Dans vos temps libres ou projets, quelle activité vous passionne le plus ?" required></textarea>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Catégorie</label>
                        <select name="category" class="form-select" required>
                            <option value="riasec">RIASEC (Personnalité & Préférences Métiers)</option>
                            <option value="academic">Aptitudes & Matières Scolaires</option>
                            <option value="career_goal">Objectifs Professionnels</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Dimension</label>
                        <select name="dimension" class="form-select">
                            <option value="I">I - Investigateur</option>
                            <option value="R">R - Réaliste</option>
                            <option value="A">A - Artistique</option>
                            <option value="S">S - Social</option>
                            <option value="E">E - Entreprenant</option>
                            <option value="C">C - Conventionnel</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Ordre d'affichage</label>
                        <input type="number" name="order_number" class="form-control" value="{{ $quizzes->count() + 1 }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Options & Pondérations (JSON) <span class="text-danger">*</span></label>
                    <textarea name="options_json" rows="4" class="form-control font-monospace" required>[
  {"text": "Concevoir des logiciels et résoudre des problèmes algorithmiques complexes", "dimension": "I", "score": 3},
  {"text": "Construire, fabriquer des mécanismes ou diriger des chantiers", "dimension": "R", "score": 3},
  {"text": "Créer des designs, des contenus multimédias ou écrire", "dimension": "A", "score": 3},
  {"text": "Gérer une entreprise, négocier des contrats et diriger une équipe", "dimension": "E", "score": 3}
]</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-ci-orange rounded-pill px-4">Créer la question</button>
            </div>
        </form>
    </div>
</div>
@endsection

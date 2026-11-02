<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\Etablissement;
use App\Models\Filiere;
use App\Models\Interest;
use App\Models\Serie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $domainInfo = Domain::where('slug', 'informatique-ia-numerique')->first();
        $domainSante = Domain::where('slug', 'sante-medecine')->first();
        $domainEco = Domain::where('slug', 'economie-gestion-finance')->first();
        $domainBtp = Domain::where('slug', 'genie-civil-btp-architecture')->first();
        $domainAgro = Domain::where('slug', 'agronomie-forets-agro-industrie')->first();
        $domainDroit = Domain::where('slug', 'droit-sciences-politiques')->first();
        $domainMines = Domain::where('slug', 'mines-geologie-energies')->first();
        $domainLog = Domain::where('slug', 'logistique-transport-commerce')->first();

        // Institutions
        $ufhb = Etablissement::where('sigle', 'UFHB')->first();
        $inphb = Etablissement::where('sigle', 'INP-HB')->first();
        $una = Etablissement::where('sigle', 'UNA')->first();
        $uao = Etablissement::where('sigle', 'UAO')->first();
        $usp = Etablissement::where('sigle', 'USP')->first();
        $uman = Etablissement::where('sigle', 'U-Man')->first();
        $esatic = Etablissement::where('sigle', 'ESATIC')->first();
        $pigier = Etablissement::where('sigle', 'PIGIER-CI')->first();
        $ucao = Etablissement::where('sigle', 'UCAO-UUA')->first();
        $cbcg = Etablissement::where('sigle', 'CBCG-Cocody')->first();

        // Series
        $serieC = Serie::where('code', 'C')->first();
        $serieD = Serie::where('code', 'D')->first();
        $serieE = Serie::where('code', 'E')->first();
        $serieA1 = Serie::where('code', 'A1')->first();
        $serieA2 = Serie::where('code', 'A2')->first();
        $serieF4 = Serie::where('code', 'F4')->first();
        $serieF2 = Serie::where('code', 'F2')->first();
        $serieG2 = Serie::where('code', 'G2')->first();

        $programsData = [
            [
                'program' => [
                    'name' => 'Licence en Génie Logiciel & Intelligence Artificielle',
                    'code' => 'LIC-GL-IA',
                    'slug' => 'licence-genie-logiciel-intelligence-artificielle',
                    'domain_id' => $domainInfo->id,
                    'degree_level' => 'Licence',
                    'duration_years' => 3,
                    'description' => 'Formation d\'excellence en algorithmique avancée, développement web & mobile, architectures cloud et intégration de modèles d\'intelligence artificielle.',
                    'admission_requirements' => 'BAC C, D, E ou F2. Moyenne minimale de 12/20 en Mathématiques et Sciences Physiques.',
                    'career_opportunities' => ['Développeur Fullstack', 'Ingénieur IA & Data', 'Architecte Logiciel', 'Chef de Projet Numérique'],
                    'difficulty_level' => 'Exigeant',
                    'market_demand_rating' => 5,
                    'average_starting_salary_fcfa' => 450000,
                    'is_featured' => true,
                ],
                'series' => [
                    ['id' => $serieC->id, 'priority' => 'Fortement Recommandé', 'min' => 11.5, 'coeffs' => ['Mathématiques' => 4, 'Physique-Chimie' => 3]],
                    ['id' => $serieD->id, 'priority' => 'Recommandé', 'min' => 12.5, 'coeffs' => ['Mathématiques' => 4, 'Physique-Chimie' => 3]],
                    ['id' => $serieE->id, 'priority' => 'Fortement Recommandé', 'min' => 11.0, 'coeffs' => ['Mathématiques' => 4, 'Technologie' => 3]],
                    ['id' => $serieF2->id, 'priority' => 'Possible avec mise à niveau', 'min' => 13.0, 'coeffs' => ['Électronique' => 3, 'Mathématiques' => 3]],
                ],
                'institutions' => [
                    ['id' => $ufhb->id, 'tuition' => 30000, 'public' => true],
                    ['id' => $esatic->id, 'tuition' => 100000, 'public' => true],
                    ['id' => $pigier->id, 'tuition' => 850000, 'public' => false],
                ],
                'interests' => ['Intelligence Artificielle & Data Science', 'Développement d\'Applications Web & Mobile'],
            ],
            [
                'program' => [
                    'name' => 'Diplôme d\'Ingénieur des Travaux Publics / Génie Civil',
                    'code' => 'ING-GC-TP',
                    'slug' => 'diplome-ingenieur-travaux-publics-genie-civil',
                    'domain_id' => $domainBtp->id,
                    'degree_level' => 'Ingenieur',
                    'duration_years' => 5,
                    'description' => 'Formation d\'ingénieurs concepteurs d\'infrastructures de transport, ponts, autoroutes, barrages hydroélectriques et grands édifices en Afrique de l\'Ouest.',
                    'admission_requirements' => 'BAC C, E ou F4 avec mention. Concours d\'entrée aux classes préparatoires INP-HB Yamoussoukro.',
                    'career_opportunities' => ['Ingénieur Calculateur Structures', 'Directeur de Travaux BTP', 'Chef de Chantier Autoroutier', 'Expert Contrôle Technique'],
                    'difficulty_level' => 'Très Exigeant',
                    'market_demand_rating' => 5,
                    'average_starting_salary_fcfa' => 600000,
                    'is_featured' => true,
                ],
                'series' => [
                    ['id' => $serieC->id, 'priority' => 'Fortement Recommandé', 'min' => 13.0, 'coeffs' => ['Mathématiques' => 5, 'Physique-Chimie' => 4]],
                    ['id' => $serieE->id, 'priority' => 'Fortement Recommandé', 'min' => 12.5, 'coeffs' => ['Mathématiques' => 4, 'Technologie' => 4]],
                    ['id' => $serieF4->id, 'priority' => 'Recommandé', 'min' => 13.5, 'coeffs' => ['Génie Civil' => 5, 'Mathématiques' => 4]],
                ],
                'institutions' => [
                    ['id' => $inphb->id, 'tuition' => 50000, 'public' => true],
                    ['id' => $usp->id, 'tuition' => 30000, 'public' => true],
                ],
                'interests' => ['Génie Civil, Ponts & Chaussées, Architecture'],
            ],
            [
                'program' => [
                    'name' => 'Doctorat d\'État en Médecine Générale',
                    'code' => 'DOC-MED',
                    'slug' => 'doctorat-etat-medecine-generale',
                    'domain_id' => $domainSante->id,
                    'degree_level' => 'Doctorat',
                    'duration_years' => 8,
                    'description' => 'Cycle complet d\'études médicales avec stages cliniques au CHU (Treichville, Cocody, Yopougon, Bouaké), diagnostique, thérapeutique et internat.',
                    'admission_requirements' => 'BAC C ou D avec moyenne générale supérieure ou égale à 13.5/20 et excellentes notes en SVT et Physique-Chimie.',
                    'career_opportunities' => ['Médecin Généraliste', 'Chirurgien', 'Pédiatre', 'Médecin Urgentiste', 'Santé Publique'],
                    'difficulty_level' => 'Très Exigeant',
                    'market_demand_rating' => 5,
                    'average_starting_salary_fcfa' => 500000,
                    'is_featured' => true,
                ],
                'series' => [
                    ['id' => $serieD->id, 'priority' => 'Obligatoire', 'min' => 13.5, 'coeffs' => ['Sciences de la Vie et de la Terre' => 5, 'Physique-Chimie' => 4]],
                    ['id' => $serieC->id, 'priority' => 'Recommandé', 'min' => 14.0, 'coeffs' => ['Mathématiques' => 4, 'Physique-Chimie' => 5]],
                ],
                'institutions' => [
                    ['id' => $ufhb->id, 'tuition' => 30000, 'public' => true],
                    ['id' => $uao->id, 'tuition' => 30000, 'public' => true],
                ],
                'interests' => ['Médecine, Soins & Chirurgie', 'Pharmacie & Recherche Biomédicale'],
            ],
            [
                'program' => [
                    'name' => 'BTS Informatique Développeur d\'Applications (IDA)',
                    'code' => 'BTS-IDA',
                    'slug' => 'bts-informatique-developpeur-applications',
                    'domain_id' => $domainInfo->id,
                    'degree_level' => 'BTS',
                    'duration_years' => 2,
                    'description' => 'Diplôme d\'État ivoirien formant des techniciens supérieurs opérationnels en programmation, gestion de bases de données et maintenance applicative.',
                    'admission_requirements' => 'BAC C, D, E, F2, G2 ou A1. Sélection sur dossier.',
                    'career_opportunities' => ['Technicien Développeur', 'Administrateur de Bases de Données', 'Gestionnaire de Parc IT'],
                    'difficulty_level' => 'Modéré',
                    'market_demand_rating' => 4,
                    'average_starting_salary_fcfa' => 250000,
                    'is_featured' => false,
                ],
                'series' => [
                    ['id' => $serieD->id, 'priority' => 'Recommandé', 'min' => 10.0, 'coeffs' => ['Mathématiques' => 3]],
                    ['id' => $serieC->id, 'priority' => 'Recommandé', 'min' => 10.0, 'coeffs' => ['Mathématiques' => 3]],
                    ['id' => $serieG2->id, 'priority' => 'Recommandé', 'min' => 11.0, 'coeffs' => ['Comptabilité' => 2, 'Mathématiques' => 3]],
                ],
                'institutions' => [
                    ['id' => $cbcg->id, 'tuition' => 25000, 'public' => true],
                    ['id' => $pigier->id, 'tuition' => 650000, 'public' => false],
                ],
                'interests' => ['Développement d\'Applications Web & Mobile'],
            ],
            [
                'program' => [
                    'name' => 'Licence en Sciences Économiques & Gestion d\'Entreprise',
                    'code' => 'LIC-ECO-GEST',
                    'slug' => 'licence-sciences-economiques-gestion',
                    'domain_id' => $domainEco->id,
                    'degree_level' => 'Licence',
                    'duration_years' => 3,
                    'description' => 'Maîtrise des principes micro/macroéconomiques, analyse financière, comptabilité analytique, fiscalité ivoirienne et gestion managériale.',
                    'admission_requirements' => 'BAC C, D, G2, A1. Bonne base en mathématiques appliquées et raisonnement logique.',
                    'career_opportunities' => ['Analyste Financier', 'Contrôleur de Gestion', 'Chargé d\'Affaires Banque', 'Gestionnaire Comptable'],
                    'difficulty_level' => 'Modéré',
                    'market_demand_rating' => 4,
                    'average_starting_salary_fcfa' => 350000,
                    'is_featured' => true,
                ],
                'series' => [
                    ['id' => $serieG2->id, 'priority' => 'Fortement Recommandé', 'min' => 11.0, 'coeffs' => ['Comptabilité' => 4, 'Mathématiques' => 3]],
                    ['id' => $serieC->id, 'priority' => 'Recommandé', 'min' => 10.5, 'coeffs' => ['Mathématiques' => 4]],
                    ['id' => $serieD->id, 'priority' => 'Recommandé', 'min' => 11.0, 'coeffs' => ['Mathématiques' => 3]],
                    ['id' => $serieA1->id, 'priority' => 'Recommandé', 'min' => 11.5, 'coeffs' => ['Mathématiques' => 3, 'Philosophie' => 3]],
                ],
                'institutions' => [
                    ['id' => $ufhb->id, 'tuition' => 30000, 'public' => true],
                    ['id' => $uao->id, 'tuition' => 30000, 'public' => true],
                    ['id' => $ucao->id, 'tuition' => 750000, 'public' => false],
                ],
                'interests' => ['Finance de Marché, Audit & Banque', 'Création d\'Entreprise & Entrepreneuriat'],
            ],
            [
                'program' => [
                    'name' => 'Licence en Droit Privé & Carrières Judiciaires',
                    'code' => 'LIC-DROIT-JUD',
                    'slug' => 'licence-droit-prive-carrieres-judiciaires',
                    'domain_id' => $domainDroit->id,
                    'degree_level' => 'Licence',
                    'duration_years' => 3,
                    'description' => 'Étude approfondie du droit civil, droit pénal, droit commercial OHADA, procédure civile et organisation judiciaire en Côte d\'Ivoire.',
                    'admission_requirements' => 'BAC A1, A2 ou D. Excellente expression écrite et capacités d\'analyse critique.',
                    'career_opportunities' => ['Juriste d\'Entreprise', 'Avocat (après CRFPA)', 'Magistrat (via concours ENA)', 'Notaire', 'Huissier de Justice'],
                    'difficulty_level' => 'Exigeant',
                    'market_demand_rating' => 4,
                    'average_starting_salary_fcfa' => 350000,
                    'is_featured' => false,
                ],
                'series' => [
                    ['id' => $serieA1->id, 'priority' => 'Fortement Recommandé', 'min' => 11.5, 'coeffs' => ['Français' => 4, 'Philosophie' => 4]],
                    ['id' => $serieA2->id, 'priority' => 'Fortement Recommandé', 'min' => 11.5, 'coeffs' => ['Français' => 4, 'Philosophie' => 4]],
                    ['id' => $serieD->id, 'priority' => 'Recommandé', 'min' => 11.0, 'coeffs' => ['Français' => 3, 'Philosophie' => 3]],
                ],
                'institutions' => [
                    ['id' => $ufhb->id, 'tuition' => 30000, 'public' => true],
                    ['id' => $uao->id, 'tuition' => 30000, 'public' => true],
                    ['id' => $ucao->id, 'tuition' => 700000, 'public' => false],
                ],
                'interests' => ['Justice, Magistrature & Avocature', 'Diplomatie & Relations Internationales'],
            ],
            [
                'program' => [
                    'name' => 'Diplôme d\'Ingénieur Agronome & Agroforesterie',
                    'code' => 'ING-AGRO',
                    'slug' => 'diplome-ingenieur-agronome-agroforesterie',
                    'domain_id' => $domainAgro->id,
                    'degree_level' => 'Ingenieur',
                    'duration_years' => 5,
                    'description' => 'Formation d\'ingénieurs de haut niveau dédiés aux filières stratégiques cacao, café, hévéa, palmier à huile, cultures vivrières et valorisation durable des sols.',
                    'admission_requirements' => 'BAC C ou D. Sélection et concours d\'entrée à l\'École Supérieure d\'Agronomie (ESA).',
                    'career_opportunities' => ['Ingénieur de Production Agricole', 'Directeur d\'Exploitation Agro-industrielle', 'Chercheur CNRA', 'Consultant Filières Durables'],
                    'difficulty_level' => 'Exigeant',
                    'market_demand_rating' => 5,
                    'average_starting_salary_fcfa' => 500000,
                    'is_featured' => true,
                ],
                'series' => [
                    ['id' => $serieD->id, 'priority' => 'Fortement Recommandé', 'min' => 12.0, 'coeffs' => ['Sciences de la Vie et de la Terre' => 4, 'Physique-Chimie' => 3]],
                    ['id' => $serieC->id, 'priority' => 'Recommandé', 'min' => 11.5, 'coeffs' => ['Mathématiques' => 3, 'Physique-Chimie' => 3]],
                ],
                'institutions' => [
                    ['id' => $inphb->id, 'tuition' => 50000, 'public' => true],
                    ['id' => $una->id, 'tuition' => 30000, 'public' => true],
                ],
                'interests' => ['Agronomie Durable & Agro-Alimentaire'],
            ],
            [
                'program' => [
                    'name' => 'Licence Professionnelle en Logistique Portuaire & Transport Maritime',
                    'code' => 'LIC-LOG-PORT',
                    'slug' => 'licence-logistique-portuaire-transport-maritime',
                    'domain_id' => $domainLog->id,
                    'degree_level' => 'Licence',
                    'duration_years' => 3,
                    'description' => 'Formation spécialisée dans la gestion des opérations portuaires, manutention de conteneurs, courtage maritime et logistique internationale au Port Autonome de San Pedro et d\'Abidjan.',
                    'admission_requirements' => 'BAC D, C, G2, A1 ou G3. Goût pour les opérations logistiques et le commerce extérieur.',
                    'career_opportunities' => ['Coordinateur des Opérations Portuaires', 'Commissionnaire Agréé en Douane', 'Responsable Supply Chain'],
                    'difficulty_level' => 'Modéré',
                    'market_demand_rating' => 5,
                    'average_starting_salary_fcfa' => 400000,
                    'is_featured' => true,
                ],
                'series' => [
                    ['id' => $serieG2->id, 'priority' => 'Fortement Recommandé', 'min' => 11.0, 'coeffs' => ['Comptabilité' => 3, 'Mathématiques' => 2]],
                    ['id' => $serieD->id, 'priority' => 'Recommandé', 'min' => 11.0, 'coeffs' => ['Mathématiques' => 2]],
                    ['id' => $serieA1->id, 'priority' => 'Recommandé', 'min' => 11.5, 'coeffs' => ['Anglais' => 3, 'Français' => 3]],
                ],
                'institutions' => [
                    ['id' => $usp->id, 'tuition' => 30000, 'public' => true],
                    ['id' => $pigier->id, 'tuition' => 800000, 'public' => false],
                ],
                'interests' => ['Logistique Portuaire, Transit & Supply Chain'],
            ],
            [
                'program' => [
                    'name' => 'Ingénieur des Mines, Géologie & Pétrole',
                    'code' => 'ING-MINES',
                    'slug' => 'ingenieur-mines-geologie-petrole',
                    'domain_id' => $domainMines->id,
                    'degree_level' => 'Ingenieur',
                    'duration_years' => 5,
                    'description' => 'Formation d\'ingénieurs miniers et pétroliers pour l\'exploration géologique, l\'exploitation des gisements d\'or, de manganèse, de nickel et les champs pétroliers offshore en Côte d\'Ivoire.',
                    'admission_requirements' => 'BAC C ou E ou D (avec mention). Sélection rigoureuse.',
                    'career_opportunities' => ['Ingénieur Minier', 'Géologue d\'Exploration', 'Ingénieur Réservoir Pétrolier', 'Directeur de Carrière'],
                    'difficulty_level' => 'Très Exigeant',
                    'market_demand_rating' => 5,
                    'average_starting_salary_fcfa' => 650000,
                    'is_featured' => true,
                ],
                'series' => [
                    ['id' => $serieC->id, 'priority' => 'Fortement Recommandé', 'min' => 13.0, 'coeffs' => ['Mathématiques' => 4, 'Physique-Chimie' => 4]],
                    ['id' => $serieE->id, 'priority' => 'Fortement Recommandé', 'min' => 12.5, 'coeffs' => ['Mathématiques' => 4, 'Technologie' => 4]],
                    ['id' => $serieD->id, 'priority' => 'Recommandé', 'min' => 13.0, 'coeffs' => ['Sciences de la Vie et de la Terre' => 4, 'Physique-Chimie' => 4]],
                ],
                'institutions' => [
                    ['id' => $uman->id, 'tuition' => 30000, 'public' => true],
                    ['id' => $inphb->id, 'tuition' => 50000, 'public' => true],
                ],
                'interests' => ['Mines, Pétrole & Géosciences'],
            ],
        ];

        foreach ($programsData as $item) {
            $filiere = Filiere::updateOrCreate(
                ['code' => $item['program']['code']],
                $item['program']
            );

            // Attach series
            foreach ($item['series'] as $s) {
                $filiere->series()->syncWithoutDetaching([
                    $s['id'] => [
                        'priority_level' => $s['priority'],
                        'min_recommended_grade' => $s['min'],
                        'key_subject_coefficients' => json_encode($s['coeffs'], JSON_THROW_ON_ERROR),
                    ],
                ]);
            }

            // Attach institutions
            foreach ($item['institutions'] as $inst) {
                $filiere->etablissements()->syncWithPivotValues([$inst['id']], [
                    'tuition_fee_annual_fcfa' => $inst['tuition'],
                    'is_public_funded' => $inst['public'],
                    'is_accredited' => true,
                ], false);
            }

            // Attach interests
            if (!empty($item['interests'])) {
                $interestIds = Interest::whereIn('name', $item['interests'])->pluck('id');
                $filiere->interests()->sync($interestIds);
            }
        }
    }
}

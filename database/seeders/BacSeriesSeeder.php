<?php

namespace Database\Seeders;

use App\Models\Serie;
use Illuminate\Database\Seeder;

class BacSeriesSeeder extends Seeder
{
    public function run(): void
    {
        $series = [
            [
                'code' => 'A1',
                'name' => 'Littéraire (Option Mathématiques & Philosophie)',
                'stream' => 'Enseignement Général',
                'description' => 'Série littéraire renforcée en mathématiques et logique.',
                'key_subjects' => ['Français', 'Philosophie', 'Mathématiques', 'Anglais'],
            ],
            [
                'code' => 'A2',
                'name' => 'Littéraire (Option Langues & Sciences Humaines)',
                'stream' => 'Enseignement Général',
                'description' => 'Série axée sur les lettres modernes, les langues vivantes, l\'histoire et la géographie.',
                'key_subjects' => ['Français', 'Philosophie', 'Histoire-Géographie', 'Anglais'],
            ],
            [
                'code' => 'C',
                'name' => 'Scientifique (Mathématiques & Sciences Physiques)',
                'stream' => 'Enseignement Général',
                'description' => 'Filière scientifique d\'excellence orientée vers les mathématiques pures et la physique théorique et expérimentale.',
                'key_subjects' => ['Mathématiques', 'Physique-Chimie', 'Français'],
            ],
            [
                'code' => 'D',
                'name' => 'Scientifique (Sciences de la Vie et de la Terre)',
                'stream' => 'Enseignement Général',
                'description' => 'Série scientifique orientée vers la biologie, la médecine, la géologie, la chimie et les mathématiques.',
                'key_subjects' => ['Sciences de la Vie et de la Terre', 'Physique-Chimie', 'Mathématiques'],
            ],
            [
                'code' => 'E',
                'name' => 'Technologique & Mathématique',
                'stream' => 'Enseignement Technique',
                'description' => 'Combinaison de mathématiques de haut niveau et de technologie industrielle.',
                'key_subjects' => ['Mathématiques', 'Physique-Chimie', 'Technologie'],
            ],
            [
                'code' => 'F1',
                'name' => 'Construction Mécanique',
                'stream' => 'Enseignement Technique',
                'description' => 'Étude de la mécanique, dessin industriel et conception de systèmes mécaniques.',
                'key_subjects' => ['Mécanique', 'Mathématiques', 'Physique-Chimie'],
            ],
            [
                'code' => 'F2',
                'name' => 'Électronique',
                'stream' => 'Enseignement Technique',
                'description' => 'Systèmes électroniques, automatismes et télécommunications.',
                'key_subjects' => ['Électronique', 'Mathématiques', 'Physique-Chimie'],
            ],
            [
                'code' => 'F3',
                'name' => 'Électrotechnique',
                'stream' => 'Enseignement Technique',
                'description' => 'Énergie électrique, distribution et moteurs industriels.',
                'key_subjects' => ['Électrotechnique', 'Mathématiques', 'Physique-Chimie'],
            ],
            [
                'code' => 'F4',
                'name' => 'Génie Civil & Bâtiment',
                'stream' => 'Enseignement Technique',
                'description' => 'Construction, calcul de structures, topographie et architecture.',
                'key_subjects' => ['Génie Civil', 'Mathématiques', 'Physique-Chimie'],
            ],
            [
                'code' => 'F5',
                'name' => 'Chimie Industrielle & Procédés',
                'stream' => 'Enseignement Technique',
                'description' => 'Génie des procédés chimiques et laboratoires industriels.',
                'key_subjects' => ['Chimie', 'Physique-Chimie', 'Mathématiques'],
            ],
            [
                'code' => 'F6',
                'name' => 'Biologie Médicale & Analyses',
                'stream' => 'Enseignement Technique',
                'description' => 'Laboratoires d\'analyses biomédicales et biochimiques.',
                'key_subjects' => ['Biologie', 'Biochimie', 'Sciences Physiques'],
            ],
            [
                'code' => 'F7',
                'name' => 'Biochimie',
                'stream' => 'Enseignement Technique',
                'description' => 'Sciences des aliments, microbiologie et contrôle qualité.',
                'key_subjects' => ['Biochimie', 'Microbiologie', 'Mathématiques'],
            ],
            [
                'code' => 'G1',
                'name' => 'Secrétariat, Bureautique & Communication',
                'stream' => 'Enseignement Technique',
                'description' => 'Gestion administrative, secrétariat bilingue et bureautique.',
                'key_subjects' => ['Bureautique', 'Français', 'Anglais'],
            ],
            [
                'code' => 'G2',
                'name' => 'Comptabilité, Finance & Gestion',
                'stream' => 'Enseignement Technique',
                'description' => 'Techniques comptables, gestion d\'entreprise et mathématiques financières.',
                'key_subjects' => ['Comptabilité', 'Mathématiques', 'Économie'],
            ],
            [
                'code' => 'G3',
                'name' => 'Commerce, Vente & Marketing',
                'stream' => 'Enseignement Technique',
                'description' => 'Négociation commerciale, distribution et marketing.',
                'key_subjects' => ['Techniques Commerciales', 'Économie', 'Français'],
            ],
        ];

        foreach ($series as $serie) {
            Serie::updateOrCreate(['code' => $serie['code']], $serie);
        }
    }
}

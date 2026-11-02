<?php

namespace Database\Seeders;

use App\Models\OrientationQuiz;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $quizzes = [
            [
                'question_text' => 'Quel type d\'activité préférez-vous réaliser pendant vos heures de projets ?',
                'category' => 'riasec',
                'dimension' => 'I',
                'order_number' => 1,
                'options' => [
                    ['text' => 'Résoudre des énigmes mathématiques, analyser des données ou programmer', 'dimension' => 'I', 'score' => 3],
                    ['text' => 'Monter, réparer des circuits, conduire des travaux manuels ou sur chantier', 'dimension' => 'R', 'score' => 3],
                    ['text' => 'Dessiner, rédiger des récits, concevoir des visuels artistiques', 'dimension' => 'A', 'score' => 3],
                    ['text' => 'Organiser une équipe, négocier, convaincre et porter un projet commercial', 'dimension' => 'E', 'score' => 3],
                ],
            ],
            [
                'question_text' => 'Quel environnement de travail vous inspire le plus pour votre futur métier ?',
                'category' => 'riasec',
                'dimension' => 'R',
                'order_number' => 2,
                'options' => [
                    ['text' => 'Un laboratoire de recherche médicale ou une salle de serveurs informatiques', 'dimension' => 'I', 'score' => 3],
                    ['text' => 'Un grand chantier de construction, une usine industrielle ou une exploitation agricole', 'dimension' => 'R', 'score' => 3],
                    ['text' => 'Un tribunal de justice, un bureau de conseil en stratégie ou un ministère', 'dimension' => 'E', 'score' => 3],
                    ['text' => 'Un hôpital ou un centre d\'aide sociale pour soigner et accompagner', 'dimension' => 'S', 'score' => 3],
                ],
            ],
            [
                'question_text' => 'Face à un problème complexe, quelle est votre première réaction ?',
                'category' => 'riasec',
                'dimension' => 'I',
                'order_number' => 3,
                'options' => [
                    ['text' => 'Décomposer le problème méthodiquement avec logique, équations et algorithmes', 'dimension' => 'I', 'score' => 3],
                    ['text' => 'Consulter les gens, échanger et trouver une solution humaine et concertée', 'dimension' => 'S', 'score' => 3],
                    ['text' => 'Établir des tableaux financiers, vérifier la conformité et les règles', 'dimension' => 'C', 'score' => 3],
                    ['text' => 'Prendre l\'initiative, décider vite et mobiliser des ressources pour gagner', 'dimension' => 'E', 'score' => 3],
                ],
            ],
            [
                'question_text' => 'Quelle cause nationale en Côte d\'Ivoire souhaiteriez-vous faire progresser ?',
                'category' => 'career_goal',
                'dimension' => 'S',
                'order_number' => 4,
                'options' => [
                    ['text' => 'La transformation numérique, l\'IA et les start-ups technologiques', 'dimension' => 'I', 'score' => 3],
                    ['text' => 'La modernisation des infrastructures routières, des ponts et des ports', 'dimension' => 'R', 'score' => 3],
                    ['text' => 'L\'accès universel à la santé de qualité et l\'éradication des épidémies', 'dimension' => 'S', 'score' => 3],
                    ['text' => 'L\'industrialisation agricole locale (cacao, café, anacarde, vivrier)', 'dimension' => 'R', 'score' => 3],
                ],
            ],
            [
                'question_text' => 'Quelle matière du lycée vous a procuré le plus de satisfaction intellectuelle ?',
                'category' => 'academic',
                'dimension' => 'I',
                'order_number' => 5,
                'options' => [
                    ['text' => 'Les Mathématiques et les Sciences Physiques', 'dimension' => 'I', 'score' => 3],
                    ['text' => 'Les Sciences de la Vie et de la Terre (Biologie/Géologie)', 'dimension' => 'I', 'score' => 3],
                    ['text' => 'La Philosophie, le Français et les Langues vivantes', 'dimension' => 'A', 'score' => 3],
                    ['text' => 'La Comptabilité, l\'Économie et l\'Histoire-Géo', 'dimension' => 'E', 'score' => 3],
                ],
            ],
            [
                'question_text' => 'Comment envisagez-vous la durée idéale de vos études supérieures ?',
                'category' => 'preference',
                'dimension' => 'C',
                'order_number' => 6,
                'options' => [
                    ['text' => 'Formation courte et professionnalisante (BTS - Bac+2) pour entrer vite sur le marché', 'dimension' => 'C', 'score' => 2],
                    ['text' => 'Cycle universitaire classique (Licence Bac+3 puis Master Bac+5)', 'dimension' => 'I', 'score' => 3],
                    ['text' => 'Grande École d\'Ingénieurs (Bac+5 avec classes préparatoires)', 'dimension' => 'I', 'score' => 3],
                    ['text' => 'Études longues et exigeantes (Doctorat en Médecine ou Recherche - Bac+8)', 'dimension' => 'I', 'score' => 3],
                ],
            ],
        ];

        foreach ($quizzes as $q) {
            OrientationQuiz::updateOrCreate(['order_number' => $q['order_number']], $q);
        }
    }
}

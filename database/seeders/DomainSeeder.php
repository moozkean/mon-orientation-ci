<?php

namespace Database\Seeders;

use App\Models\Domain;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    public function run(): void
    {
        $domains = [
            [
                'name' => 'Informatique, IA & Technologies du Numérique',
                'slug' => 'informatique-ia-numerique',
                'description' => 'Génie logiciel, intelligence artificielle, cybersécurité, réseaux & télécoms, big data.',
                'icon' => 'laptop',
                'color_code' => '#FF8200',
            ],
            [
                'name' => 'Sciences de la Santé & Médecine',
                'slug' => 'sante-medecine',
                'description' => 'Médecine générale, pharmacie, odontostomatologie, sciences infirmières, santé publique.',
                'icon' => 'heart-pulse',
                'color_code' => '#EF4444',
            ],
            [
                'name' => 'Sciences Économiques, Gestion & Finance',
                'slug' => 'economie-gestion-finance',
                'description' => 'Finance de marché, comptabilité, audit, banque, management d\'entreprise, marketing digital.',
                'icon' => 'cash-coin',
                'color_code' => '#10B981',
            ],
            [
                'name' => 'Génie Civil, BTP & Architecture',
                'slug' => 'genie-civil-btp-architecture',
                'description' => 'Travaux publics, calcul des structures, urbanisme, architecture bioclimatique, topographie.',
                'icon' => 'building-gear',
                'color_code' => '#3B82F6',
            ],
            [
                'name' => 'Agronomie, Forêts & Agro-Industrie',
                'slug' => 'agronomie-forets-agro-industrie',
                'description' => 'Production végétale, agroforesterie, élevage, sécurité alimentaire, transformation agroalimentaire.',
                'icon' => 'tree',
                'color_code' => '#009A44',
            ],
            [
                'name' => 'Droit, Sciences Politiques & Criminologie',
                'slug' => 'droit-sciences-politiques',
                'description' => 'Droit privé, droit public des affaires, carrières judiciaires, relations internationales, diplomatie.',
                'icon' => 'shield-fill-check',
                'color_code' => '#8B5CF6',
            ],
            [
                'name' => 'Mines, Géologie & Énergies Renouvelables',
                'slug' => 'mines-geologie-energies',
                'description' => 'Exploitation minière, pétrole, géosciences, transition énergétique, hydrocarbures.',
                'icon' => 'lightning-charge',
                'color_code' => '#F59E0B',
            ],
            [
                'name' => 'Logistique Portuaire, Transport & Commerce International',
                'slug' => 'logistique-transport-commerce',
                'description' => 'Gestion des plateformes portuaires (PAA/PASP), supply chain, transit maritime et douanes.',
                'icon' => 'truck',
                'color_code' => '#06B6D4',
            ],
        ];

        foreach ($domains as $domain) {
            Domain::updateOrCreate(['slug' => $domain['slug']], $domain);
        }
    }
}

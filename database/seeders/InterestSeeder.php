<?php

namespace Database\Seeders;

use App\Models\Interest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InterestSeeder extends Seeder
{
    public function run(): void
    {
        $interests = [
            ['name' => 'Intelligence Artificielle & Data Science', 'category' => 'Technologie', 'icon' => 'cpu'],
            ['name' => 'Développement d\'Applications Web & Mobile', 'category' => 'Technologie', 'icon' => 'code-slash'],
            ['name' => 'Cybersécurité & Réseaux Télécoms', 'category' => 'Technologie', 'icon' => 'shield-lock'],
            ['name' => 'Médecine, Soins & Chirurgie', 'category' => 'Santé', 'icon' => 'heart-pulse'],
            ['name' => 'Pharmacie & Recherche Biomédicale', 'category' => 'Santé', 'icon' => 'capsule'],
            ['name' => 'Création d\'Entreprise & Entrepreneuriat', 'category' => 'Affaires', 'icon' => 'rocket-takeoff'],
            ['name' => 'Finance de Marché, Audit & Banque', 'category' => 'Affaires', 'icon' => 'bank'],
            ['name' => 'Génie Civil, Ponts & Chaussées, Architecture', 'category' => 'Sciences & Ingénierie', 'icon' => 'buildings'],
            ['name' => 'Mines, Pétrole & Géosciences', 'category' => 'Sciences & Ingénierie', 'icon' => 'gem'],
            ['name' => 'Agronomie Durable & Agro-Alimentaire', 'category' => 'Nature & Agriculture', 'icon' => 'flower1'],
            ['name' => 'Logistique Portuaire, Transit & Supply Chain', 'category' => 'Affaires', 'icon' => 'box-seam'],
            ['name' => 'Justice, Magistrature & Avocature', 'category' => 'Droit & Société', 'icon' => 'hammer'],
            ['name' => 'Diplomatie & Relations Internationales', 'category' => 'Droit & Société', 'icon' => 'globe-americas'],
            ['name' => 'Marketing Digital & Communication Médias', 'category' => 'Communication', 'icon' => 'megaphone'],
            ['name' => 'Électronique, Robotique & Domotique', 'category' => 'Technologie', 'icon' => 'robot'],
        ];

        foreach ($interests as $item) {
            Interest::updateOrCreate(
                ['name' => $item['name']],
                array_merge($item, ['slug' => Str::slug($item['name'])])
            );
        }
    }
}

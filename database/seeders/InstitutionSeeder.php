<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Etablissement;
use Illuminate\Database\Seeder;

class InstitutionSeeder extends Seeder
{
    public function run(): void
    {
        $abidjan = City::where('name', 'Abidjan')->first()->id;
        $yamoussoukro = City::where('name', 'Yamoussoukro')->first()->id;
        $bouake = City::where('name', 'Bouaké')->first()->id;
        $daloa = City::where('name', 'Daloa')->first()->id;
        $korhogo = City::where('name', 'Korhogo')->first()->id;
        $sanpedro = City::where('name', 'San-Pédro')->first()->id;
        $man = City::where('name', 'Man')->first()->id;
        $bondoukou = City::where('name', 'Bondoukou')->first()->id;

        $institutions = [
            // Public Universities & Grandes Écoles
            [
                'name' => 'Université Félix Houphouët-Boigny',
                'sigle' => 'UFHB',
                'type' => 'universite_publique',
                'city_id' => $abidjan,
                'address' => 'Boulevard de l\'Université, Cocody, Abidjan',
                'email' => 'presidence@univ-fhb.edu.ci',
                'phone' => '+225 27 22 44 00 00',
                'website' => 'https://www.univ-fhb.edu.ci',
                'logo_url' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=200',
                'cover_image' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=800',
                'description' => 'La plus grande et plus ancienne université publique de Côte d\'Ivoire. Réputée pour ses UFR de Sciences Médicales, Droit, Économie, Mathématiques et Informatique.',
                'is_accredited_mesrs' => true,
                'is_accredited_cames' => true,
                'established_year' => 1964,
            ],
            [
                'name' => 'Institut National Polytechnique Félix Houphouët-Boigny',
                'sigle' => 'INP-HB',
                'type' => 'grande_ecole_publique',
                'city_id' => $yamoussoukro,
                'address' => 'BP 1093 Yamoussoukro, Côte d\'Ivoire',
                'email' => 'contact@inphb.ci',
                'phone' => '+225 30 64 66 66',
                'website' => 'https://www.inphb.ci',
                'logo_url' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=200',
                'cover_image' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=800',
                'description' => 'Pôle technologique et polytechnique d\'élite sous-régionale réunissant l\'ESCAE, l\'ESTP, l\'ESIE, l\'ESA et l\'ESMines.',
                'is_accredited_mesrs' => true,
                'is_accredited_cames' => true,
                'established_year' => 1996,
            ],
            [
                'name' => 'Université Nangui Abrogoua',
                'sigle' => 'UNA',
                'type' => 'universite_publique',
                'city_id' => $abidjan,
                'address' => 'Abobo-Adjamé, Abidjan 02 BP 801',
                'email' => 'contact@univ-na.ci',
                'phone' => '+225 27 20 30 40 50',
                'website' => 'https://www.univ-na.ci',
                'logo_url' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=200',
                'cover_image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800',
                'description' => 'Université spécialisée dans les Sciences de la Nature, l\'Environnement, la Biotechnologie, la Santé et la gestion des ressources naturelles.',
                'is_accredited_mesrs' => true,
                'is_accredited_cames' => true,
                'established_year' => 1995,
            ],
            [
                'name' => 'Université Alassane Ouattara',
                'sigle' => 'UAO',
                'type' => 'universite_publique',
                'city_id' => $bouake,
                'address' => 'Campus 1 & 2, Bouaké',
                'email' => 'info@univ-ao.edu.ci',
                'phone' => '+225 31 63 30 20',
                'website' => 'https://www.univ-ao.edu.ci',
                'logo_url' => 'https://images.unsplash.com/photo-1519452635265-7b1fbfd1e4e0?w=200',
                'cover_image' => 'https://images.unsplash.com/photo-1519452635265-7b1fbfd1e4e0?w=800',
                'description' => 'Deuxième pôle universitaire du pays, reconnu pour l\'excellence de ses facultés de Droit, Sciences Économiques, Sociologie et Lettres.',
                'is_accredited_mesrs' => true,
                'is_accredited_cames' => true,
                'established_year' => 1992,
            ],
            [
                'name' => 'Université de San Pedro',
                'sigle' => 'USP',
                'type' => 'universite_publique',
                'city_id' => $sanpedro,
                'address' => 'Route de Grand-Béréby, San-Pédro',
                'email' => 'contact@usp.edu.ci',
                'phone' => '+225 34 71 80 00',
                'website' => 'https://www.usp.edu.ci',
                'logo_url' => 'https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?w=200',
                'cover_image' => 'https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?w=800',
                'description' => 'Université thématique orientée vers les Métiers de la Mer, la Logistique Portuaire, le BTP, le Tourisme et l\'Agriculture littorale.',
                'is_accredited_mesrs' => true,
                'is_accredited_cames' => true,
                'established_year' => 2021,
            ],
            [
                'name' => 'Université de Man',
                'sigle' => 'U-Man',
                'type' => 'universite_publique',
                'city_id' => $man,
                'address' => 'Quartier Kassiapleu, Man',
                'email' => 'courrier@univ-man.edu.ci',
                'phone' => '+225 33 79 12 12',
                'website' => 'https://www.univ-man.edu.ci',
                'logo_url' => 'https://images.unsplash.com/photo-1576495199011-eb94736d05d6?w=200',
                'cover_image' => 'https://images.unsplash.com/photo-1576495199011-eb94736d05d6?w=800',
                'description' => 'Université scientifique à vocation polytechnique, spécialisée en Mines, Géologie, Métallurgie, Énergies et Ingénierie des matériaux.',
                'is_accredited_mesrs' => true,
                'is_accredited_cames' => true,
                'established_year' => 2016,
            ],
            [
                'name' => 'École Supérieure Africaine des TIC',
                'sigle' => 'ESATIC',
                'type' => 'grande_ecole_publique',
                'city_id' => $abidjan,
                'address' => 'Zone 3, Treichville, Abidjan',
                'email' => 'info@esatic.edu.ci',
                'phone' => '+225 27 21 21 44 44',
                'website' => 'https://www.esatic.ci',
                'logo_url' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=200',
                'cover_image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800',
                'description' => 'Grande école publique de référence sous-régionale en Télécommunications, Sécurité Informatique, Systèmes Distribués et IA.',
                'is_accredited_mesrs' => true,
                'is_accredited_cames' => true,
                'established_year' => 2012,
            ],
            // Private Institutions & BTS
            [
                'name' => 'Pigier Côte d\'Ivoire',
                'sigle' => 'PIGIER-CI',
                'type' => 'grande_ecole_privee',
                'city_id' => $abidjan,
                'address' => 'Plateau, Boulevard Clozel, Abidjan',
                'email' => 'pigier@pigierci.com',
                'phone' => '+225 27 20 30 35 00',
                'website' => 'https://www.pigierci.com',
                'logo_url' => 'https://images.unsplash.com/photo-1492538368677-f6e0afe31dcc?w=200',
                'cover_image' => 'https://images.unsplash.com/photo-1492538368677-f6e0afe31dcc?w=800',
                'description' => 'Leader de la formation professionnelle supérieure privée en gestion, audit, finance, informatique de gestion et ressources humaines.',
                'is_accredited_mesrs' => true,
                'is_accredited_cames' => true,
                'established_year' => 1956,
            ],
            [
                'name' => 'Université Catholique de l\'Afrique de l\'Ouest',
                'sigle' => 'UCAO-UUA',
                'type' => 'universite_privee',
                'city_id' => $abidjan,
                'address' => 'Cocody Boulevard Latrille, Abidjan',
                'email' => 'secretariat@ucao-uua.org',
                'phone' => '+225 27 22 40 06 50',
                'website' => 'https://www.ucao-uua.org',
                'logo_url' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=200',
                'cover_image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=800',
                'description' => 'Institution universitaire confessionnelle reconnue pour la rigueur de ses facultés d\'Économie, Gestion, Droit, Philosophie et Sciences.',
                'is_accredited_mesrs' => true,
                'is_accredited_cames' => true,
                'established_year' => 2000,
            ],
            [
                'name' => 'Centre de Bureautique et de Communication de Cocody',
                'sigle' => 'CBCG-Cocody',
                'type' => 'centre_bts',
                'city_id' => $abidjan,
                'address' => 'Cocody Saint-Jean, Abidjan',
                'email' => 'info@cbcgcocody.ci',
                'phone' => '+225 27 22 44 23 10',
                'website' => 'https://www.cbcgcocody.ci',
                'logo_url' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=200',
                'cover_image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800',
                'description' => 'Établissement public technique d\'excellence préparant aux filières du BTS d\'État : IDA, FCGE, GEC, Logistique et Secrétariat.',
                'is_accredited_mesrs' => true,
                'is_accredited_cames' => true,
                'established_year' => 1970,
            ],
        ];

        foreach ($institutions as $inst) {
            Etablissement::updateOrCreate(['name' => $inst['name']], $inst);
        }
    }
}

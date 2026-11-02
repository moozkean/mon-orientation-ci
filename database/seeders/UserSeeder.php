<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Serie;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $abidjan = City::where('name', 'Abidjan')->first()->id;
        $serieC = Serie::where('code', 'C')->first()->id;
        $serieD = Serie::where('code', 'D')->first()->id;

        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@orientation.ci'],
            [
                'name' => 'Kouassi Konan (Admin MESRS)',
                'email' => 'admin@orientation.ci',
                'matricule' => 'MESRS-ADMIN-001',
                'phone' => '+225 07 08 09 10 11',
                'password' => Hash::make('AdminCI2026!'),
                'role' => 'admin',
                'city_id' => $abidjan,
            ]
        );

        // Student 1 (BAC C)
        User::updateOrCreate(
            ['email' => 'amadou.traore@student.ci'],
            [
                'name' => 'Amadou Traoré',
                'email' => 'amadou.traore@student.ci',
                'phone' => '+225 05 01 02 03 04',
                'password' => Hash::make('Etudiant2026!'),
                'role' => 'student',
                'city_id' => $abidjan,
                'bac_serie_id' => $serieC,
                'bac_year' => 2026,
                'bac_mention' => 'Bien',
                'academic_grades' => [
                    'Mathématiques' => 15.5,
                    'Physique-Chimie' => 14.0,
                    'Français' => 12.0,
                    'Philosophie' => 11.5,
                    'Anglais' => 14.5,
                ],
            ]
        );

        // Student 2 (BAC D)
        User::updateOrCreate(
            ['email' => 'marie.kouame@student.ci'],
            [
                'name' => 'Marie Kouamé',
                'email' => 'marie.kouame@student.ci',
                'phone' => '+225 01 02 03 04 05',
                'password' => Hash::make('Etudiant2026!'),
                'role' => 'student',
                'city_id' => $abidjan,
                'bac_serie_id' => $serieD,
                'bac_year' => 2026,
                'bac_mention' => 'Très-Bien',
                'academic_grades' => [
                    'Sciences de la Vie et de la Terre' => 16.5,
                    'Physique-Chimie' => 15.0,
                    'Mathématiques' => 14.0,
                    'Français' => 13.5,
                ],
            ]
        );
    }
}

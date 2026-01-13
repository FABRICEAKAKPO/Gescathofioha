<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vérifier si un utilisateur admin existe déjà
        if (!User::where('email', 'admin@exemple.com')->exists()) {
            User::create([
                'name' => 'Administrateur',
                'email' => 'admin@exemple.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]);
        }
        
        // Mettre à jour l'utilisateur existant avec de nouveaux identifiants
        $adminUser = User::where('email', 'admin@exemple.com')->first();
        if ($adminUser) {
            $adminUser->update([
                'password' => Hash::make('fioha123456'),
                'email' => 'fabriceakakpo786@gmail.com', 
            ]);
        }
    }
}

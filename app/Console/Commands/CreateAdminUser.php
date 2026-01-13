<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-user {--name=} {--email=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer un utilisateur administrateur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->option('name') ?? $this->ask('Nom');
        $email = $this->option('email') ?? $this->ask('Email');
        $password = $this->option('password') ?? $this->secret('Mot de passe');
        
        if (User::where('email', $email)->exists()) {
            $this->error('Un utilisateur avec cet email existe déjà.');
            return 1;
        }
        
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);
        
        $this->info('Utilisateur administrateur créé avec succès!');
        
        return 0;
    }
}

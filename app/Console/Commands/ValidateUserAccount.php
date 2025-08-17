<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ValidateUserAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aeerg:validate-user {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::where('email', $this->argument('email'))->firstOrFail();
        $user->update(['valide' => true]);

        // Envoyer une notification à l'utilisateur
        $user->notify(new AccountValidatedNotification());

        $this->info("Le compte de {$user->nom} a été validé avec succès !");
    }

}

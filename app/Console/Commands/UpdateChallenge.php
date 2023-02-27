<?php

namespace App\Console\Commands;

use App\Models\Challenge;
use App\Models\Client;
use App\User;
use Illuminate\Console\Command;

class UpdateChallenge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:challenge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finaliza Desafios com mais de 15 dias';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $headers = ['Desafio', 'Enviado'];

       Challenge::where('answered_at','<',now()->subDays(30))->update(['status' => 'FINALIZADO']);
       Client::where('created_at', '<', now()->subDays(6))->update(['liberado' => '1']);
       

       $this->info('Atualizado');

    }
}

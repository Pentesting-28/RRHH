<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee\ContractTermination\ContractTermination;

class Contract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:contract_termination';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete ContractTermination';

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
        $array = [
            ['name' => 'Periodo de prueba'],
            ['name' => 'Finalización de contrato'],
            ['name' => 'Artículo 213: Causa Justificada'],
            ['name' => 'Artículo 212: Menos de 2 años'],
            ['name' => 'Artículo 213: Mutuo acuerdo'],
            ['name' => 'Renuncia'],
            ['name' => 'Por muerte del trabajador'],
        ];

        foreach ($array as $key => $value) {
            // echo $value['id'];
            // return $value['id'];
            ContractTermination::updateOrCreate(['id' => $key+1 ], $value );
        }
    }
}

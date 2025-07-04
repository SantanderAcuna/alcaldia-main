<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CrearTriggersAuditoria extends Command
{
    
     protected $signature = 'auditoria:triggers';
    protected $description = 'Crea los triggers de auditoría automáticamente';

    public function handle()
    {
        $path = database_path('triggers/auditoria_triggers.sql');

        if (!file_exists($path)) {
            $this->error("Archivo no encontrado: $path");
            return 1;
        }

        $sql = file_get_contents($path);
        DB::unprepared($sql);

        $this->info('Triggers de auditoría creados correctamente.');
        return 0;
    }
}

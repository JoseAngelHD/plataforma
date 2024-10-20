<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SchoolController;

class AddPermissionsToSchools extends Command
{
    /**
     * El nombre y la firma del comando de consola.
     *
     * @var string
     */
    protected $signature = 'schools:add-permissions';

    /**
     * La descripción del comando de consola.
     *
     * @var string
     */
    protected $description = 'Añadir tablas de permisos a todos los colegios existentes';

    /**
     * Ejecutar el comando de consola.
     *
     * @return void
     */
    public function handle()
    {
        $controller = new SchoolController();
        $controller->addPermissionsTableToExistingSchools();

        $this->info('Tablas de permisos añadidas a los colegios existentes.');
    }
}

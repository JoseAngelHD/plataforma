<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SchoolController;

class AddRolesAndPermissionsToSchools extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schools:add-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Agregar tablas de permisos y roles a todos los colegios existentes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $schoolController = new SchoolController();
        $schoolController->addPermissionsTableToExistingSchools();

        $this->info('Permisos y roles agregados a todos los colegios existentes.');

        return 0;
    }
}

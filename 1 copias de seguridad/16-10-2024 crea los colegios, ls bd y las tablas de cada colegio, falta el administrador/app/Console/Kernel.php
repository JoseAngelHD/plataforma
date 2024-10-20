<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Definir los comandos Artisan que ofrece tu aplicación.
     *
     * @var array
     */
    protected $commands = [
        // Registrar aquí tus comandos personalizados
        \App\Console\Commands\AddRolesAndPermissionsToSchools::class,
        \App\Console\Commands\AddPermissionsToSchools::class,
        \App\Console\Commands\AddUsersTableToExistingSchools::class,
    ];

    /**
     * Define la programación de comandos.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Registra los comandos personalizados de la aplicación.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
        
    }
}

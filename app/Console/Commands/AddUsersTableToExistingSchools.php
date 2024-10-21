<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SchoolController;

class AddUsersTableToExistingSchools extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schools:add-users-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add users table to all existing schools';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $controller = new SchoolController();
        $controller->addUserTableToExistingSchools();

        $this->info('Tabla users agregada a los colegios existentes.');
    }
}


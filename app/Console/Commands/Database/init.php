<?php


namespace App\Console\Commands\Database;

use Illuminate\Console\Command;

class init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initalize an empty sqlite db';

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
        $db_connection = env('DB_CONNECTION', '');
        $db_database = env('DB_DATABASE', '');

        // check if we are using SQLite
        if ($db_connection != 'sqlite') {
            $this->error('No sqlite db connection defined in .env');
            exit(0);
        }

        if (preg_match('&^\/&', $db_database) == 0 ) {
            $this->error('No absolute path to sqlite db [' . $db_database . ']');
            exit(1);
        }
        if (file_exists($db_database)) {
            $this->info('Database ['. $db_database .'] already exists.');
        } else {
            $this->info('Creating sqlite db [' . $db_database . ']');
            $result = touch($db_database);

            if (!$result) {
                $this->error("Couldn't create $db_database");
                exit(1);
            }
        }
    }
}

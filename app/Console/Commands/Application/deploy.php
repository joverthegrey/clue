<?php


namespace App\Console\Commands\Application;

use Dotenv\Dotenv;
use Illuminate\Console\Command;


/**
 *
 * TODO still buggy, db doesn't want to play nice
 *
 * Autodeploy with default settings
 *
 * Class deploy
 * @package App\Console\Commands\Application
 */
class deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy the application';

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
        $working_dir = base_path();

        // copy .env.example to.env
        $this->info('Creating .env file');
        $result = copy($working_dir . '/.env.example', $working_dir . '/.env');

        if (!$result) {
            $this->error("Couldn't create $working_dir/.env file");
            exit(1);
        }

        // reload env
        $dotenv = Dotenv::create($working_dir);
        $dotenv->load();

        // init db
        $this->info("Initialize db");
        $this->call('db:init');

        // migrate and seed db
        $this->info("Migrate and seed db");
        $this->call('migrate', ['--seed' => true]);

        // import clues
        $this->info("Import clues");
        $this->call('clue:import', ['csv' => "$working_dir/cluedo.csv"]);

        // done
        $this->info("Done");
    }
}

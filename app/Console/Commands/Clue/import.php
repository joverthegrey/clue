<?php


namespace App\Console\Commands\Clue;

use App\Clue;
use App\Type;
use Exception;
use Illuminate\Console\Command;

class import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clue:import
        {csv : Path to csv file}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import clues from a csv file';

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

        $clues = [];
        $csv = $this->argument('csv');
        try {
            if (($handle = fopen($csv, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    array_push($clues, $data);
                }
                fclose($handle);
            } else {
                $this->error("Couldn't open $csv");
            }
        } catch (Exception $e) {
            $this->error("Couldn't open $csv, {$e->getMessage()}");
            exit(1);
        }

        // delete old clues
        foreach(Clue::all() as $c) {
            $c->delete();
        }

        // add new clues
        foreach ($clues as $clue) {
            $type =  Type::where('name', '=', $clue[1])->first();
            if (!$type) {
                $this->error("Unknown type of clue '{$clue[1]}' for clue '{$clue[0]}',skipping");
                continue;
            }

            $c = new Clue();
            $c->name = $clue[0];
            $c->type()->associate($type);
            $c->save();

            $this->info("Added new clue [{$clue[0]}, {$clue[1]}]");
        }
    }

}

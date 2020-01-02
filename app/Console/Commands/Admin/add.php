<?php

namespace App\Console\Commands\Admin;

use App\User;
use App\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class add extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:add
        {name : The name of the admin}
        {email : Email address of the admin}
        {password : Password for the admin}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add an admin user';

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
        // get the admin role
        $admin_role = Role::where('name', '=', 'admin')->first();

        // get the data
        $data = $this->arguments();
        unset($data['command']);
        $data['password'] = Hash::make($this->argument('password'));

        // check if the user already exists
        if (User::where('email', $data['email'])->first()) {
            $this->error("Email '" . $data['email'] . "' already used for user '" . $data['name'] . "'");
        } else {
            // try to create the user
            try{
                $user = User::firstOrNew($data);
                $user->role()->associate($admin_role);
                $user->save();
            } catch (Exception $e) {
                $this->comment('Error occurred while creating a new admin user: ' . $e->getMessage());
            }

            $this->comment("User '" . $data['name'] . "' created.");
        }

    }
}

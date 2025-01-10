<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class AssignRoleForExistUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-role-for-exist-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign role for exist user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::where('id', 1)->first();
        $user->assignRole('super-admin');

        dump('Assign role super-admin for ' . $user->email);

        $user = User::where('id', 2)->first();
        $user->assignRole('user-ads');

        dump('Assign role user-ads for ' . $user->email);

        $user = User::where('id', 3)->first();
        $user->assignRole('user-ads');

        dump('Assign role user-ads for ' . $user->email);

        $user = User::where('id', 4)->first();
        $user->assignRole('manager-file');

        dump('Assign role manager-file for ' . $user->email);

        $user = User::where('id', 5)->first();
        $user->assignRole('manager-push-system');

        $user = User::where('id', 6)->first();
        $user->assignRole('user-ads');

        dump('Assign role user-ads for ' . $user->email);
    }
}

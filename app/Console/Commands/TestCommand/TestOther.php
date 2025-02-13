<?php

namespace App\Console\Commands\TestCommand;

use Illuminate\Console\Command;
use Spatie\Ssh\Ssh;

class TestOther extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $url;
    protected $signature = 'test:other';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test other command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $domain = 'gamesnood.com';
        $server = '139.162.44.151';
        $script = "bash /binhchay/create_site.sh $domain 2>&1";
        $output = Ssh::create('root', $server)
            ->execute($script);

        dd($output->getOutput(), $output->getErrorOutput());
    }
}

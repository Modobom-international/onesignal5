<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportDomainFromCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-domain-from-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import domain from CSV file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = fopen('domains.csv', 'r');
        while (($line = fgetcsv($file)) !== false) {
            $domain = $line[0];
            $server = $line[1];
            $provider = $line[2];
            $email = $line[3];
            $date = $line[4];

            dispatch(new UpDomain($domain, $server, $provider, $email, $date));
        }
        fclose($file);
    }
}

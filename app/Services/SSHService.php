<?php

namespace App\Services;

use Spatie\Ssh\Ssh;

class SSHService
{
    protected $server;
    protected $user;
    protected $privateKey;

    public function __construct($server)
    {
        $this->server = $server;
        $this->user = config('services.ssh.ssh_user');
        $this->privateKey = config('services.ssh.ssh_private_key');
    }

    public function runScript($domain)
    {
        try {
            $script = "bash /binhchay/create_site.sh $domain";

            $output = Ssh::create($this->user, $this->server)
                ->execute($script);

            \Log::info('-----------Result :' . json_encode($output));

            return $output->getOutput();
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    public function getOutputResult($domain)
    {
        try {
            $filePath = '/binhchay/output/' . $domain . '.json';

            $jsonData = Ssh::create($this->user, $this->server)
                ->disableStrictHostKeyChecking()
                ->execute("cat $filePath")
                ->getOutput();

            \Log::info('-----------Result json :' . json_encode($output));

            return json_decode($jsonData, true);
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    private function handleException(RequestException $e)
    {
        if ($e->hasResponse()) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }

        return ['error' => 'Something went wrong'];
    }
}

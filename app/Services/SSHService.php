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
        $this->server = config($server);
        $this->user = config('services.ssh.ssh_user');
        $this->privateKey = config('services.ssh.ssh_private_key');
    }

    public function runScript($domain)
    {
        try {
            $script = "bash /create_site.sh $domain";

            $output = Ssh::create($this->user, $this->server)
                ->usePrivateKey($this->privateKey)
                ->execute($script);

            $statusCode = Ssh::create($this->user, $this->server)
                ->usePrivateKey($this->privateKey)
                ->execute("echo $?");

            if (trim($output) === "SUCCESS" && (int)trim($statusCode) === 0) {
                return json_decode($output, true);
            } else {
                return ['error' => 'Something went wrong'];
            }
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

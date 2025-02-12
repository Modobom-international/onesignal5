<?php

namespace App\Services;

use Spatie\Ssh\Ssh;

class SSHService
{
    protected $host;
    protected $user;
    protected $privateKey;

    public function __construct()
    {
        $this->host = env('SSH_HOST');
        $this->user = env('SSH_USER');
        $this->privateKey = env('SSH_PRIVATE_KEY');
    }

    public function runScript($scriptPath)
    {
        if (!file_exists($scriptPath)) {
            return "Script không tồn tại: $scriptPath";
        }

        $script = file_get_contents($scriptPath);

        $output = Ssh::create($this->user, $this->host)
            ->usePrivateKey($this->privateKey)
            ->disableStrictHostKeyChecking()
            ->execute([$script]);

        return implode("\n", $output);
    }
}

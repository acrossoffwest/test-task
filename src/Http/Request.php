<?php

namespace App\Http;

use App\Helpers\ArrayMapper;
use App\Contracts\RequestContract;

class Request implements RequestContract
{
    protected ArrayMapper $request;
    protected ArrayMapper $server;

    /**
     * @param array $request $_REQUEST
     * @param array $server $_SERVER
     */
    public function __construct(array $request, array $server)
    {
        $this->request = ArrayMapper::make($request);
        $this->server = ArrayMapper::make($server);
    }

    public function all(array $keys, bool $allRequired = false): array
    {
        $result = [];

        foreach ($keys as $key) {
            $v = $this->get(''.$key);
            if ($allRequired && empty($v)) {
                throw new \Exception('The '.$key.' attribute can\'t be empty.');
            }
            $result[$key] = $v;
        }

        return $result;
    }

    public function get(string $key): mixed
    {
        return $this->request->get($key);
    }

    public function getMethod(): string
    {
        return $this->server->get('REQUEST_METHOD');
    }

    public function isPost(): bool
    {
        return $this->getMethod() === 'POST';
    }
}

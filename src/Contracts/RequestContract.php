<?php

namespace App\Contracts;

interface RequestContract
{
    public function all(array $keys): ?array;
    public function get(string $key): mixed;
    public function getMethod(): string;
    public function getServerProtocol(): string;
    public function isPost(): bool;
}

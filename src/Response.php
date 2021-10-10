<?php

namespace App;

class Response
{
    private array $data;
    private int $status;
    private array $headers = [
        'Content-Type' => 'application/json;  charset=UTF-8'
    ];

    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function setStatus(int $status = 200): static
    {
        $this->status = $status;
        return $this;
    }
    public function addHeader(string $key, string $value): static
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function render(): ?string
    {
        http_response_code($this->status);
        foreach ($this->headers as $key => $header) {
            header($key.': '.$header);
        }

        return json_encode($this->data);
    }
}

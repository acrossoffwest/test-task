<?php

require_once "../vendor/autoload.php";

use App\Request;
use App\Response;
use App\Application;

$dotenv = Dotenv\Dotenv::createImmutable(realpath(__DIR__.'/..'));
$dotenv->load();

try {
    try {
        $json = file_get_contents('php://input');
        $_REQUEST = array_merge($_REQUEST, json_decode($json, true));
    } catch (\Throwable) {}

    $request = new Request($_REQUEST, $_SERVER);
    echo Application::run($request);
} catch (\Throwable $e) {
    echo (new Response())
        ->setData([
            "success" => false,
            "message" => $e->getMessage(),
        ])
        ->setStatus(500)
        ->render();
}

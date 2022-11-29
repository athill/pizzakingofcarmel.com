<?php
use App\Utils;

// .env
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// exception handling
set_exception_handler(function ($ex) {
    $logger = Utils::getLogger();

    $logger->error($ex->getMessage() . "\n" . $ex->getTraceAsString());
});

set_error_handler(function (int $errno, string $errstr, string $errfile,int $errline, array $errcontext) {
    $logger = Utils::getLogger();

    $logger->error("$errfile:$errline - $errstr");    
});

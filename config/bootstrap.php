 <?php

 use Dotenv\Dotenv;

 require_once '../vendor/autoload.php';

 $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
 $dotenv->load();

 require_once __DIR__ . '/database.php';
 <?php

 use Dotenv\Dotenv;

 require_once dirname(__DIR__) . "/vendor/autoload.php";

 $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
 $dotenv->load();


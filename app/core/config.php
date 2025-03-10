<?php
require(__DIR__. '/../../vendor/autoload.php');

use Dotenv\Dotenv;
//load the .env file
$dotenv = Dotenv::createImmutable(__DIR__. '/../../');
$dotenv->load();

if ($_SERVER['SERVER_NAME'] == 'mvc-dog-application') {
  define('EMAILUSERNAME', $_ENV['EMAIL_USERNAME']);
  define('EMAILPASSWORD', $_ENV['EMAIL_PASSWORD']);
  define('ADMINNAME', $_ENV['ADMINNAME']);
  define('ADMINSURNAME', $_ENV['ADMINSURNAME']);
  define('ADMINMAIL', $_ENV['ADMINMAIL']);
  define('LOGS', __DIR__."//..//..//". "logs");
  define('ROOT', 'http://mvc-dog-application/');
  define('DBHOST', 'localhost');
  define('DBNAME', 'mvc_dog_application');
  define('DBUSER', 'root');
  define('DBPASSWORD', $_ENV['DB_PASSWORD']);
  define('JWT_ACCESS_KEY', $_ENV['ACCESS_KEY']);
  define('JWT_REFRESH_KEY', $_ENV['REFRESH_KEY']);
} else {
  /*   we can use this ROOT constant in a index.php file to define a path <a href="<?= ROOT ?>path/to/page">Click Here</a>; The <?= ROOT?> syntax is a shorthand for <php? echo ROOT; ?>*/
  define('EMAILUSERNAME', $_ENV['EMAIL_USERNAME']);
  define('EMAILPASSWORD', $_ENV['EMAIL_PASSWORD']);
  define('ADMINNAME', $_ENV['ADMINNAME']);
  define('ADMINSURNAME', $_ENV['ADMINSURNAME']);
  define('ADMINMAIL', $_ENV['ADMINMAIL']);
  define('LOGS', __DIR__."//..//..//". "logs");
  define('ROOT', 'https://apachebackend.lorenzo-viganego.com/mvc-dog-application/');
  define('DBHOST', 'localhost');
  define('DBNAME', 'mvc_dog_application');
  define('DBUSER', 'lorenzo');
  define('DBPASSWORD', $_ENV['DB_PASSWORD']);
  define('JWT_ACCESS_KEY', $_ENV['ACCESS_KEY']);
  define('JWT_REFRESH_KEY', $_ENV['REFRESH_KEY']);
};

//used to set debug mode on or off, in debug mode on we are goin to show all the errors, is used only in development modality, once that the application is online is must be set as false in order to not show users what errors happen
define('DEBUG', true);


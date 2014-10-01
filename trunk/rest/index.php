<?php
require_once 'flight/Flight.php';
require_once 'jsonindent.php';
require_once 'restArtikal.php';
require_once 'restKonobar.php';
require_once 'restPorudzbina.php';
require_once 'restDistributer.php';
require_once 'restKategorija.php';
require_once 'restSto.php';
require_once 'restRazduzenje.php';
require_once 'restStavka.php';


Flight::register('db', 'Database', array('kafic'));
$json_podaci = file_get_contents("php://input");
Flight::set('json_podaci', $json_podaci );

Flight::route('/', function(){
   // echo 'hello world!';
});

Flight::start();
?>

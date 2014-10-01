<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/24/14
 * Time: 12:53 PM
 */
require_once (__DIR__ .'/../class/Distributer.php');

Flight::route('GET /distributer', function(){
    Distributer::vratiSveDistributere();
});

Flight::route('GET /distributer/@distributerID', function($distributerID){
    Distributer::vratiDistributera($distributerID);
});

Flight::route('POST /distributer', function(){
    $distributer = new Distributer("distributerID", "nazivDistributera");
    $distributer->unesiDistributera();
});

Flight::route('POST /distributer/@distributerID', function($distributerID){
    $distributer = new Distributer("distributerID", "nazivDistributera");
    $distributer->izmeniDistributera($distributerID);

});

Flight::route('DELETE /distributer/@distributerID', function($distributerID){
    $distributer = new Distributer("distributerID", "nazivDistributera");
    $distributer->obrisiDistributera($distributerID);
});

?>
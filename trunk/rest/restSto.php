<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/24/14
 * Time: 1:57 PM
 */

require_once (__DIR__ .'/../class/Sto.php');

Flight::route('GET /sto', function(){
    Sto::vratiSveStolove();
});

Flight::route('GET /sto/@stoID', function($stoID){
    Sto::vratiSto($stoID);
});

Flight::route('POST /sto', function(){
    $sto = new Sto("stoID", "brojStola");
    $sto->unesiSto();
});

Flight::route('POST /sto/@stoID', function($stoID){
    $sto = new Sto("stoID", "brojStola");
    $sto->izmeniSto($stoID);

});

Flight::route('DELETE /sto/@stoID', function($stoID){
    $sto = new Sto("stoID", "brojStola");
    $sto->obrisiKategoriju($stoID);
});

?>
<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/24/14
 * Time: 2:21 PM
 */

require_once (__DIR__ .'/../class/Razduzenje.php');

Flight::route('GET /razduzenje', function(){
    Razduzenje::vratiSvaRazduzenja();
});

Flight::route('GET /razduzenje/@razduzenjeID', function($razduzenjeID){
    Razduzenje::vratiRazduzenje($razduzenjeID);
});

Flight::route('POST /razduzenje', function(){
    $razduzenje = new Razduzenje("razduzenjeID", "ukupnaVrednost", "konobarID", "porudzbinaID");
    $razduzenje->unesiRazduzenje();
});

Flight::route('POST /razduzenje/@razduzenjeID', function($razduzenjeID){
    $razduzenje = new Razduzenje("razduzenjeID", "ukupnaVrednost", "konobarID", "porudzbinaID");
    $razduzenje->izmeniRazduzenje($razduzenjeID);

});

Flight::route('DELETE /razduzenje/@razduzenjeID', function($razduzenjeID){
    $razduzenje = new Razduzenje("razduzenjeID", "ukupnaVrednost", "konobarID", "porudzbinaID");
    $razduzenje->obrisiRazduzenje($razduzenjeID);
});

?>
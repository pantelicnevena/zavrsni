<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/24/14
 * Time: 1:43 PM
 */

require_once (__DIR__ .'/../class/Kategorija.php');

Flight::route('GET /kategorija', function(){
    Kategorija::vratiSveKategorije();
});

Flight::route('GET /kategorija/@kategorijaID', function($kategorijaID){
    Kategorija::vratiKategoriju($kategorijaID);
});

Flight::route('POST /kategorija', function(){
    $kategorija = new Kategorija("kategorijaID", "nazivKategorije");
    $kategorija->unesiKategoriju();
});

Flight::route('POST /kategorija/@kategorijaID', function($kategorijaID){
    $kategorija = new Kategorija("kategorijaID", "nazivKategorije");
    $kategorija->izmeniKategoriju($kategorijaID);

});

Flight::route('DELETE /kategorija/@kategorijaID', function($kategorijaID){
    $kategorija = new Kategorija("kategorijaID", "nazivKategorije");
    $kategorija->obrisiKategoriju($kategorijaID);
});

?>
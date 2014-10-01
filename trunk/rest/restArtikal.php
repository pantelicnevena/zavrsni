<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/23/14
 * Time: 1:47 PM
 */

require_once (__DIR__ . '/../class/Artikal.php');

Flight::route('GET /artikal', function(){
    Artikal::vratiSveArtikle();
});

Flight::route('GET /artikal/@artikalID', function($artikalID){
    Artikal::vratiArtikal($artikalID);
});

Flight::route('POST /artikal', function(){
        $artikal = new Artikal("artikalID", "nazivArtikla", "ambalaza", "rokTrajanja", "stanjeNaZalihama", "cena", "distributerID", "kategorijaID");
        $artikal->unesiArtikal();
});

Flight::route('POST /artikal/@artikalID', function($artikalID){
    $artikal = new Artikal("artikalID", "nazivArtikla", "ambalaza", "rokTrajanja", "stanjeNaZalihama", "cena", "distributerID", "kategorijaID");
    $artikal->izmeniArtikal($artikalID);
});

Flight::route('DELETE /artikal/@artikalID', function($artikalID){
    $artikal = new Artikal("artikalID", "nazivArtikla", "ambalaza", "rokTrajanja", "stanjeNaZalihama", "cena", "distributerID", "kategorijaID");
    $artikal->obrisiArtikal($artikalID);
});

?>
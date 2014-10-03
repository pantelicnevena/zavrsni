<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/23/14
 * Time: 1:47 PM
 */

require_once (__DIR__ .'/../class/Porudzbina.php');

Flight::route('GET /porudzbina', function(){
    Porudzbina::vratiSvePorudzbine();
});

Flight::route('GET /porudzbina/@konobarID', function($konobarID){
    Porudzbina::vratiPorudzbinuPoKonobaru($konobarID);
});

Flight::route('GET /porudzbina/id/@porudzbinaID', function($porudzbinaID){
    Porudzbina::vratiPorudzbinuPoId($porudzbinaID);
});

Flight::route('GET /porudzbina/datum/@datumPorudzbine', function($datumPorudzbine){
    Porudzbina::vratiPorudzbinuPoDatumu($datumPorudzbine);
});

Flight::route('GET /porudzbina/poslednje/nedelje', function(){
    Porudzbina::vratiPorudzbinePoslednjeNedelje();
});

Flight::route('GET /porudzbina/poslednje/mesec', function(){
    Porudzbina::vratiPorudzbinePoslednjegMeseca();
});

Flight::route('GET /porudzbina/poslednje/godine', function(){
    Porudzbina::vratiPorudzbinePoslednjeGodine();
});

Flight::route('GET /porudzbina/napravljena/@napravljena', function($napravljena){
    Porudzbina::vratiNapravljenePorudzbine($napravljena);
});

Flight::route('GET /porudzbina/razduzeno/@razduzeno', function($razduzeno){
    Porudzbina::vratiRazduzenePorudzbine($razduzeno);
});

Flight::route('POST /porudzbina', function(){
    $porudzbina = new Porudzbina("porudzbinaID", "datumPorudzbine", "razduzeno", "napravljena", "konobarID", "stoID", "ukupnaVrednost");
    $porudzbina->unesiPorudzbinu();
});

Flight::route('POST /porudzbina/@porudzbinaID', function($porudzbinaID){
    $porudzbina = new Porudzbina("porudzbinaID", "datumPorudzbine", "razduzeno", "napravljena", "konobarID", "stoID", "ukupnaVrednost");
    $porudzbina->izmeniPorudzbinu($porudzbinaID);
});

Flight::route('DELETE /porudzbina/@porudzbinaID', function($porudzbinaID){
    $porudzbina = new Porudzbina("porudzbinaID", "datumPorudzbine", "razduzeno", "napravljena", "konobarID", "stoID", "ukupnaVrednost");
    $porudzbina->obrisiPorudzbinu($porudzbinaID);
});

?>
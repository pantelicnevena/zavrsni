<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/23/14
 * Time: 1:48 PM
 */
/*
Flight::route('GET /konobar', function(){
    require_once (__DIR__ . '/../konobari.php');
    return false;
});*/

require_once (__DIR__ .'/../class/Konobar.php');

Flight::route('GET /konobar', function(){
    echo Konobar::vratiSveKonobare();
});

Flight::route('GET /konobar/@konobarID', function($konobarID){
    Konobar::vratiKonobara($konobarID);
});

Flight::route('POST /konobar', function(){
    $konobar = new Konobar("konobarID", "ime", "prezime", "godinaRodjenja", "mestoRodjenja", "korisnickoIme", "korisnickaSifra", "role", "slika");
    $konobar->unesiKonobara();

});

Flight::route('POST /konobar/@konobarID', function($konobarID){
    $konobar = new Konobar("konobarID", "ime", "prezime", "godinaRodjenja", "mestoRodjenja", "korisnickoIme", "korisnickaSifra", "role", "slika");
    $konobar->izmeniKonobara($konobarID);

});

Flight::route('DELETE /konobar/@konobarID', function($konobarID){
    $konobar = new Konobar("konobarID", "ime", "prezime", "godinaRodjenja", "mestoRodjenja", "korisnickoIme", "korisnickaSifra", "role", "slika");
    $konobar->obrisiKonobara($konobarID);
});

?>
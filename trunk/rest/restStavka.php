<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/24/14
 * Time: 2:22 PM
 */

require_once (__DIR__ .'/../class/Stavka.php');

Flight::route('GET /stavka', function(){
    Stavka::vratiSveStavke();
});

Flight::route('GET /stavka/id/@redniBrojStavke', function($redniBrojStavke){
    Stavka::vratiStavku($redniBrojStavke);
});

Flight::route('GET /stavka/@porudzbinaID', function($porudzbinaID){
    Stavka::vratiStavkuPoPorudzbini($porudzbinaID);
});

Flight::route('POST /stavka', function(){
    $stavka = new Stavka("redniBrojStavke", "kolicina", "porudzbinaID", "artikalID");
    $stavka->unesiStavku();
});

Flight::route('POST /stavka/@redniBrojStavke', function($redniBrojStavke){
    $stavka = new Stavka("redniBrojStavke", "kolicina", "porudzbinaID", "artikalID");
    $stavka->izmeniStavku($redniBrojStavke);

});

Flight::route('DELETE /stavka/@redniBrojStavke', function($redniBrojStavke){
    $stavka = new Stavka("redniBrojStavke", "kolicina", "porudzbinaID", "artikalID");
    $stavka->obrisiStavku($redniBrojStavke);
});

?>
<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/24/14
 * Time: 2:22 PM
 */

class Stavka implements JsonSerializable {
    private $redniBrojStavke;
    private $kolicina;
    private $porudzbinaID;
    private $artikalID;

    function __construct($redniBrojStavke, $kolicina, $porudzbinaID, $artikalID)
    {
        $this->redniBrojStavke = $redniBrojStavke;
        $this->kolicina = $kolicina;
        $this->porudzbinaID = $porudzbinaID;
        $this->artikalID = $artikalID;
    }

    /**
     * @param mixed $artikalID
     */
    public function setArtikalID($artikalID)
    {
        $this->artikalID = $artikalID;
    }

    /**
     * @return mixed
     */
    public function getArtikalID()
    {
        return $this->artikalID;
    }

    /**
     * @param mixed $kolicina
     */
    public function setKolicina($kolicina)
    {
        $this->kolicina = $kolicina;
    }

    /**
     * @return mixed
     */
    public function getKolicina()
    {
        return $this->kolicina;
    }

    /**
     * @param mixed $porudzbinaID
     */
    public function setPorudzbinaID($porudzbinaID)
    {
        $this->porudzbinaID = $porudzbinaID;
    }

    /**
     * @return mixed
     */
    public function getPorudzbinaID()
    {
        return $this->porudzbinaID;
    }

    /**
     * @param mixed $redniBrojStavke
     */
    public function setRedniBrojStavke($redniBrojStavke)
    {
        $this->redniBrojStavke = $redniBrojStavke;
    }

    /**
     * @return mixed
     */
    public function getRedniBrojStavke()
    {
        return $this->redniBrojStavke;
    }

    public function expose(){
        return get_object_vars($this);
    }

    function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->rednoBrojStavke ." ". $this->kolicina ." ". $this->porudzbinaID ." ". $this->artikalID;
    }

    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }

    public static function vratiSveStavke(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("stavka", "stavka.redniBrojStavke, stavka.kolicina, stavka.porudzbinaID, artikal.nazivArtikla", "artikal", "artikalID", "artikalID", null, null);
        $niz = array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
        return false;
    }

    public static function vratiStavku($redniBrojStavke){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("stavka", "stavka.redniBrojStavke, stavka.kolicina, stavka.porudzbinaID, artikal.nazivArtikla", "artikal", "artikalID", "artikalID", "redniBrojStavke = ".$redniBrojStavke, null);
        $niz=array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
    }

    public static function vratiStavkuPoPorudzbini($porudzbinaID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("stavka", "stavka.redniBrojStavke, stavka.kolicina, stavka.porudzbinaID, artikal.nazivArtikla", "artikal", "artikalID", "artikalID", "porudzbinaID = ".$porudzbinaID, null);
        $niz=array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
    }

    public function izmeniStavku($redniBrojStavke){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $podaci_json = Flight::get("json_podaci");
        $podaci = json_decode ($podaci_json);
        if ($podaci == null){
            $odgovor["poruka"] = "Niste prosledili podatke.";
            $json_odgovor = json_encode ($odgovor);
            echo $json_odgovor;
        } else {
            if (!property_exists($podaci,'kolicina')||!property_exists($podaci,'porudzbinaID')||!property_exists($podaci,'artikalID')){
                $odgovor["poruka"] = "Niste prosledili korektne podatke.";
                $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;

            } else {
                $podaci_query = array();
                foreach ($podaci as $k=>$v){
                    $v = "'".$v."'";
                    $podaci_query[$k] = $v;
                }
                if ($db->update("stavka", $redniBrojStavke, array('kolicina', 'porudzbinaID', 'artikalID'), array($podaci->kolicina, $podaci->porudzbinaID, $podaci->artikalID))){
                    $odgovor["poruka"] = "Stavka je uspešno izmenjena.";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    //echo $json_odgovor;
                    return true;

                } else {
                    $odgovor["poruka"] = "Došlo je do greške pri izmeni stavke.";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;
                }

            }
        }
    }

    public function obrisiStavku($redniBrojStavke){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        if ($db->delete("stavka", array("redniBrojStavke"),array($redniBrojStavke))){
            $odgovor["poruka"] = "Stavka je uspešno izbrisana.";
            $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;
        } else {
            $odgovor["poruka"] = "Došlo je do greške prilikom brisanja stavke.";
            $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;

        }
    }

    public function unesiStavku(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $podaci_json = Flight::get("json_podaci");
        $podaci = json_decode ($podaci_json);
        if ($podaci == null){
            $odgovor["poruka"] = "Niste prosledili podatke.";
            $json_odgovor = json_encode ($odgovor);
            echo $json_odgovor;
        } else {
            if (!property_exists($podaci,'kolicina')||!property_exists($podaci,'porudzbinaID')||!property_exists($podaci,'artikalID')){
                $odgovor["poruka"] = "Niste prosledili korektne podatke.";
                $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;

            } else {
                $podaci_query = array();
                foreach ($podaci as $k=>$v){
                    $v = "'".$v."'";
                    $podaci_query[$k] = $v;
                }
                if ($db->insert("stavka", "kolicina, porudzbinaID, artikalID", array($podaci_query["kolicina"], $podaci_query["porudzbinaID"], $podaci_query["artikalID"]))){
                    $odgovor["poruka"] = "Stavka je uspešno ubacena.";
                    $json_odgovor = json_encode ($odgovor, JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;
                } else {
                    $odgovor["poruka"] = "Došlo je do greške pri ubacivanju stavke.";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;
                }
            }
        }
    }
} 
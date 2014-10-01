<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/24/14
 * Time: 2:22 PM
 */

class Razduzenje implements JsonSerializable{
    private $razduzenjeID;
    private $ukupnaVrednost;
    private $konobarID;
    private $porudzbinaID;

    function __construct($razduzenjeID, $ukupnaVrednost, $konobarID, $porudzbinaID)
    {
        $this->razduzenjeID = $razduzenjeID;
        $this->ukupnaVrednost = $ukupnaVrednost;
        $this->konobarID = $konobarID;
        $this->porudzbinaID = $porudzbinaID;
    }

    /**
     * @param mixed $konobarID
     */
    public function setKonobarID($konobarID)
    {
        $this->konobarID = $konobarID;
    }

    /**
     * @return mixed
     */
    public function getKonobarID()
    {
        return $this->konobarID;
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
     * @param mixed $razduzenjeID
     */
    public function setRazduzenjeID($razduzenjeID)
    {
        $this->razduzenjeID = $razduzenjeID;
    }

    /**
     * @return mixed
     */
    public function getRazduzenjeID()
    {
        return $this->razduzenjeID;
    }

    /**
     * @param mixed $ukupnaVrednost
     */
    public function setUkupnaVrednost($ukupnaVrednost)
    {
        $this->ukupnaVrednost = $ukupnaVrednost;
    }

    /**
     * @return mixed
     */
    public function getUkupnaVrednost()
    {
        return $this->ukupnaVrednost;
    }

    public function expose(){
        return get_object_vars($this);
    }

    function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->razduzenjeID ." ". $this->ukupnaVrednost ." ". $this->konobarID ." ". $this->porudzbinaID;
    }

    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }

    public static function vratiSvaRazduzenja(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("razduzenje", "*", null, null, null, null, null);
        $niz = array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
        return false;
    }

    public static function vratiRazduzenje($razduzenjeID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("razduzenje", "*", null, null, null, "razduzenjeID = ".$razduzenjeID, null);
        $niz=array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
    }

    public function izmeniRazduzenje($razduzenjeID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $podaci_json = Flight::get("json_podaci");
        $podaci = json_decode ($podaci_json);
        if ($podaci == null){
            $odgovor["poruka"] = "Niste prosledili podatke";
            $json_odgovor = json_encode ($odgovor);
            echo $json_odgovor;
        } else {
            if (!property_exists($podaci,'ukupnaVrednost')||!property_exists($podaci,'konobarID')||!property_exists($podaci,'porudzbinaID')){
                $odgovor["poruka"] = "Niste prosledili korektne podatke";
                $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;

            } else {
                $podaci_query = array();
                foreach ($podaci as $k=>$v){
                    $v = "'".$v."'";
                    $podaci_query[$k] = $v;
                }
                if ($db->update("razduzenje", $razduzenjeID, array('ukupnaVrednost', 'konobarID', 'porudzbinaID'), array($podaci->ukupnaVrednost, $podaci->konobarID, $podaci->porudzbinaID))){
                    $odgovor["poruka"] = "Razduzenje je uspešno izmenjeno.";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    //echo $json_odgovor;
                    return true;

                } else {
                    $odgovor["poruka"] = "Došlo je do greške pri izmeni razduzenja.";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;
                }

            }
        }
    }

    public function obrisiRazduzenje($razduzenjeID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        if ($db->delete("razduzenje", array("razduzenjeID"),array($razduzenjeID))){
            $odgovor["poruka"] = "Razduzenje je uspešno izbrisano.";
            $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;
        } else {
            $odgovor["poruka"] = "Došlo je do greške prilikom brisanja razduzenja.";
            $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;

        }
    }

    public function unesiRazduzenje(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $podaci_json = Flight::get("json_podaci");
        $podaci = json_decode ($podaci_json);
        if ($podaci == null){
            $odgovor["poruka"] = "Niste prosledili podatke.";
            $json_odgovor = json_encode ($odgovor);
            echo $json_odgovor;
        } else {
            if (!property_exists($podaci,'razduzenjeID')||!property_exists($podaci,'ukupnaVrednost')||!property_exists($podaci,'konobarID')||!property_exists($podaci,'porudzbinaID')){
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
                if ($db->insert("razduzenje", "ukupnaVrednost, konobarID, porudzbinaID", array($podaci_query["ukupnaVrednost"], $podaci_query["konobarID"], $podaci_query["porudzbinaID"]))){
                    $odgovor["poruka"] = "Razduzenje je uspešno ubaceno.";
                    $json_odgovor = json_encode ($odgovor, JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;
                } else {
                    $odgovor["poruka"] = "Došlo je do greške pri ubacivanju razduzenja.";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;
                }
            }
        }
    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/23/14
 * Time: 2:48 PM
 */

class Porudzbina implements JsonSerializable {
    private $porudzbinaID;
    private $datumPorudzbine;
    private $razduzeno;
    private $napravljena;
    private $konobarID;
    private $stoID;
    private $ukupnaVrednost;

    function __construct($porudzbinaID, $datumPorudzbine, $razduzeno, $napravljena, $konobarID, $stoID)
    {
        $this->porudzbinaID = $porudzbinaID;
        $this->datumPorudzbine = $datumPorudzbine;
        $this->razduzeno = $razduzeno;
        $this->napravljena = $napravljena;
        $this->konobarID = $konobarID;
        $this->stoID = $stoID;
    }


    /**
     * @param mixed $datumPorudzbine
     */
    public function setDatumPorudzbine($datumPorudzbine)
    {
        $this->datumPorudzbine = $datumPorudzbine;
    }

    /**
     * @return mixed
     */
    public function getDatumPorudzbine()
    {
        return $this->datumPorudzbine;
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
     * @param mixed $razduzeno
     */
    public function setRazduzeno($razduzeno)
    {
        $this->razduzeno = $razduzeno;
    }

    /**
     * @return mixed
     */
    public function getRazduzeno()
    {
        return $this->razduzeno;
    }


    /**
     * @param mixed $stoID
     */
    public function setStoID($stoID)
    {
        $this->stoID = $stoID;
    }

    /**
     * @param mixed $napravljena
     */
    public function setNapravljena($napravljena)
    {
        $this->napravljena = $napravljena;
    }

    /**
     * @return mixed
     */
    public function getNapravljena()
    {
        return $this->napravljena;
    }

    /**
     * @return mixed
     */
    public function getStoID()
    {
        return $this->stoID;
    }

    public function expose(){
        return get_object_vars($this);
    }

    function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->porudzbinaID ." ". $this->datumPorudzbine ." ". $this->razduzeno;
    }

    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }

    public static function vratiSvePorudzbine(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("porudzbina", 'porudzbina.porudzbinaID, porudzbina.datumPorudzbine, porudzbina.razduzeno, porudzbina.napravljena, porudzbina.stoID, porudzbina.konobarID, konobar.ime, konobar.prezime', "konobar", "konobarID", "konobarID", null, null);
        $niz=array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
        return false;
    }

    public static function vratiPorudzbinuPoKonobaru($konobarID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("porudzbina", "porudzbinaID, datumPorudzbine, razduzeno, napravljena, konobarID, stoID", null, null, null, "konobarID = ".$konobarID, null);
        $niz=array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
        return false;
    }
	
	public static function vratiPorudzbinuPoDatumu($datumPorudzbine){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("porudzbina", "porudzbina.porudzbinaID, porudzbina.datumPorudzbine, porudzbina.razduzeno, porudzbina.napravljena, porudzbina.konobarID, porudzbina.stoID, konobar.ime, konobar.prezime", "konobar", "konobarID", "konobarID", "datumPorudzbine='". $datumPorudzbine ."'", null);
        $niz=array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
        return false;
    }
	
	public static function vratiPorudzbinePoslednjeNedelje(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("porudzbina", "porudzbina.porudzbinaID, porudzbina.datumPorudzbine, porudzbina.razduzeno, porudzbina.napravljena, porudzbina.konobarID, porudzbina.stoID, konobar.ime, konobar.prezime", "konobar", "konobarID", "konobarID", "datumPorudzbine BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()", null);
        $niz=array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
        return false;
    }
	
	public static function vratiPorudzbinePoslednjegMeseca(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("porudzbina", "porudzbina.porudzbinaID, porudzbina.datumPorudzbine, porudzbina.razduzeno, porudzbina.napravljena, porudzbina.konobarID, porudzbina.stoID, konobar.ime, konobar.prezime", "konobar", "konobarID", "konobarID", "datumPorudzbine BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()", null);
        $niz=array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
        return false;
    }
	
	public static function vratiPorudzbinePoslednjeGodine(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("porudzbina", "porudzbina.porudzbinaID, porudzbina.datumPorudzbine, porudzbina.razduzeno, porudzbina.napravljena, porudzbina.konobarID, porudzbina.stoID, konobar.ime, konobar.prezime", "konobar", "konobarID", "konobarID", "datumPorudzbine BETWEEN CURDATE() - INTERVAL 365 DAY AND CURDATE()", null);
        $niz=array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
        return false;
    }

    public static function vratiNapravljenePorudzbine($napravljena){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        //$db->nenapravljena("select porudzbina.porudzbinaID, porudzbina.napravljena, porudzbina.stoID,
        //stavka.kolicina, artikal.nazivArtikla from porudzbina
        //inner join stavka on stavka.porudzbinaID = porudzbina.porudzbinaID
        //inner join artikal on artikal.artikalID = stavka.artikalID
        //where porudzbina.napravljena = ". $napravljena);
        $db->nenapravljena("select * from porudzbina where porudzbina.napravljena = ".$napravljena);
        $niz=array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $len = count($niz);
        for($i = 0; $i < $len; $i++){
            $id = $niz[$i]->porudzbinaID;
            $db->nenapravljena("select * from stavka inner join artikal on artikal.artikalID = stavka.artikalID where porudzbinaID=".$id);
            $niz[$i]->stavke = array();
            while($red=$db->getResult()->fetch_object()){
                $niz[$i]->stavke[]=$red;
            }


        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
        return false;
    }

    public static function vratiRazduzenePorudzbine($razduzeno){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("porudzbina", 'porudzbina.porudzbinaID, porudzbina.datumPorudzbine, porudzbina.razduzeno, porudzbina.napravljena, porudzbina.stoID, porudzbina.konobarID, konobar.ime, konobar.prezime', "konobar", "konobarID", "konobarID", "porudzbina.razduzeno = ".$razduzeno, null);
        $niz=array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
        return false;
    }

    public static function vratiPorudzbinuPoId($porudzbinaID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("porudzbina", 'porudzbina.porudzbinaID, porudzbina.datumPorudzbine, porudzbina.razduzeno, porudzbina.napravljena, porudzbina.konobarID, porudzbina.stoID, konobar.ime, konobar.prezime', "konobar", "konobarID", "konobarID", "porudzbinaID = ".$porudzbinaID, null);
        $niz=array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
        return false;
    }

    public function izmeniPorudzbinu($porudzbinaID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $podaci_json = Flight::get("json_podaci");
        $podaci = json_decode ($podaci_json);
        if ($podaci == null){
            $odgovor["poruka"] = "Niste prosledili podatke";
            $json_odgovor = json_encode ($odgovor);
            echo $json_odgovor;
        } else {
            if (!property_exists($podaci,'porudzbinaID')||!property_exists($podaci,'datumPorudzbine')||!property_exists($podaci,'razduzeno')||!property_exists($podaci,'napravljena')||!property_exists($podaci,'konobarID')||!property_exists($podaci,'stoID')){
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
                if ($db->update("porudzbina", $porudzbinaID, array('datumPorudzbine', 'razduzeno', 'napravljena', 'konobarID', 'stoID'),array($podaci->datumPorudzbine, $podaci->razduzeno, $podaci->napravljena, $podaci->konobarID, $podaci->stoID))){
                    $odgovor["poruka"] = "Porudžbina je uspešno izmenjena";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    //echo $json_odgovor;
                    return false;
                } else {
                    $odgovor["poruka"] = "Došlo je do greške pri izmene porudžbine";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;
                }
            }
        }
    }

    public function obrisiPorudzbinu($porudzbinaID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        if ($db->delete("porudzbina", array("porudzbinaID"),array($porudzbinaID))){
            $odgovor["poruka"] = "Porudžbina je uspešno izbrisana";
            $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;
        } else {
            $odgovor["poruka"] = "Došlo je do greške prilikom brisanja porudžbine.";
            $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;

        }
    }

    public function unesiPorudzbinu(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $podaci_json = Flight::get("json_podaci");
        $podaci = json_decode ($podaci_json);
        if ($podaci == null){
            $odgovor["poruka"] = "Niste prosledili podatke";
            $json_odgovor = json_encode ($odgovor);
            echo $json_odgovor;
            return false;
        } else {
            if (!property_exists($podaci,'datumPorudzbine')||!property_exists($podaci,'razduzeno')||!property_exists($podaci,'napravljena')||!property_exists($podaci,'konobarID')||!property_exists($podaci,'stoID')){
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
                if ($db->insert("porudzbina", "datumPorudzbine, razduzeno, napravljena, konobarID, stoID", array($podaci_query["datumPorudzbine"], $podaci_query["razduzeno"], $podaci_query["napravljena"], $podaci_query["konobarID"], $podaci_query["stoID"]))){
                    $odgovor["poruka"] = "Porudžbina je uspešno ubacena.";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    //echo $json_odgovor;
                    return false;
                } else {
                    $odgovor["poruka"] = "Došlo je do greške pri ubacivanju porudžbine.";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;
                }
            }
        }
    }

}

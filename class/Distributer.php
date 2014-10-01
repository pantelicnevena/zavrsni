<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/24/14
 * Time: 12:51 PM
 */

class Distributer implements JsonSerializable{
    private $distributerID;
    private $nazivDistributera;

    function __construct($distributerID, $nazivDistributera)
    {
        $this->distributerID = $distributerID;
        $this->nazivDistributera = $nazivDistributera;
    }

    /**
     * @param mixed $distributerID
     */
    public function setDistributerID($distributerID)
    {
        $this->distributerID = $distributerID;
    }

    /**
     * @return mixed
     */
    public function getDistributerID()
    {
        return $this->distributerID;
    }

    /**
     * @param mixed $nazivDistributera
     */
    public function setNazivDistributera($nazivDistributera)
    {
        $this->nazivDistributera = $nazivDistributera;
    }

    /**
     * @return mixed
     */
    public function getNazivDistributera()
    {
        return $this->nazivDistributera;
    }

    public function expose(){
        return get_object_vars($this);
    }

    function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->ime ." ". $this->prezime ." (". $this->korisnickoIme .")";
    }

    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }

    public static function vratiSveDistributere(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("distributer", "*", null, null, null, null, "nazivDistributera");
        $niz = array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
        return false;
    }

    public static function vratiDistributera($distributerID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("distributer", "*", null, null, null, "distributerID = ".$distributerID, null);
        $niz=array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
    }

    public function izmeniDistributera($distributerID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $podaci_json = Flight::get("json_podaci");
        $podaci = json_decode ($podaci_json);
        if ($podaci == null){
            $odgovor["poruka"] = "Niste prosledili podatke";
            $json_odgovor = json_encode ($odgovor);
            echo $json_odgovor;
        } else {
            if (!property_exists($podaci,'nazivDistributera')){
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
                if ($db->update("distributer", $distributerID, array('nazivDistributera'), array($podaci->nazivDistributera))){
                    $odgovor["poruka"] = "Distributer je uspešno izmenjen";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    //echo $json_odgovor;
                    return true;

                } else {
                    $odgovor["poruka"] = "Došlo je do greške pri izmeni distributera";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;
                }

            }
        }
    }

    public function obrisiDistributera($distributerID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        if ($db->delete("distributer", array("distributerID"),array($distributerID))){
            $odgovor["poruka"] = "Distributer je uspešno izbrisan";
            $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;
        } else {
            $odgovor["poruka"] = "Došlo je do greške prilikom brisanja distributera";
            $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;

        }
    }

    public function unesiDistributera(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $podaci_json = Flight::get("json_podaci");
        $podaci = json_decode ($podaci_json);
        if ($podaci == null){
            $odgovor["poruka"] = "Niste prosledili podatke";
            $json_odgovor = json_encode ($odgovor);
            echo $json_odgovor;
        } else {
            if (!property_exists($podaci,'nazivDistributera')){
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
                if ($db->insert("distributer", "nazivDistributera", array($podaci_query["nazivDistributera"]))){
                    $odgovor["poruka"] = "Distributer je uspešno ubacen";
                    $json_odgovor = json_encode ($odgovor, JSON_UNESCAPED_UNICODE);
                    //echo $json_odgovor;
                    return false;
                } else {
                    $odgovor["poruka"] = "Došlo je do greške pri ubacivanju distributera";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;
                }
            }
        }
    }

} 
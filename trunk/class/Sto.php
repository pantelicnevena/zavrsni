<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/24/14
 * Time: 1:52 PM
 */

class Sto implements JsonSerializable{
    private $stoID;
    private $brojStola;

    function __construct($stoID, $brojStola)
    {
        $this->stoID = $stoID;
        $this->brojStola = $brojStola;
    }

    /**
     * @param mixed $brojStola
     */
    public function setBrojStola($brojStola)
    {
        $this->brojStola = $brojStola;
    }

    /**
     * @return mixed
     */
    public function getBrojStola()
    {
        return $this->brojStola;
    }

    /**
     * @param mixed $stoID
     */
    public function setStoID($stoID)
    {
        $this->stoID = $stoID;
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
        return $this->brojStola;
    }

    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }

    public static function vratiSveStolove(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("sto", "*", null, null, null, null, null);
        $niz = array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
        return false;
    }

    public static function vratiSto($stoID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("sto", "*", null, null, null, "stoID = ".$stoID, null);
        $niz=array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
    }

    public function izmeniSto($stoID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $podaci_json = Flight::get("json_podaci");
        $podaci = json_decode ($podaci_json);
        if ($podaci == null){
            $odgovor["poruka"] = "Niste prosledili podatke";
            $json_odgovor = json_encode ($odgovor);
            echo $json_odgovor;
        } else {
            if (!property_exists($podaci,'brojStola')){
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
                if ($db->update("sto", $stoID, array('brojStola'), array($podaci->brojStola))){
                    $odgovor["poruka"] = "Sto je uspešno izmenjen";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    //echo $json_odgovor;
                    return true;

                } else {
                    $odgovor["poruka"] = "Došlo je do greške pri izmeni stola";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;
                }

            }
        }
    }

    public function obrisiSto($stoID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        if ($db->delete("sto", array("stoID"),array($stoID))){
            $odgovor["poruka"] = "Kategorija je uspešno izbrisan";
            $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;
        } else {
            $odgovor["poruka"] = "Došlo je do greške prilikom brisanja stola.";
            $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;

        }
    }

    public function unesiSto(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $podaci_json = Flight::get("json_podaci");
        $podaci = json_decode ($podaci_json);
        if ($podaci == null){
            $odgovor["poruka"] = "Niste prosledili podatke";
            $json_odgovor = json_encode ($odgovor);
            echo $json_odgovor;
        } else {
            if (!property_exists($podaci,'brojStola')){
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
                if ($db->insert("sto", "brojStola", array($podaci_query["brojStola"]))){
                    $odgovor["poruka"] = "Sto je uspešno ubacen.";
                    $json_odgovor = json_encode ($odgovor, JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;
                } else {
                    $odgovor["poruka"] = "Došlo je do greške pri ubacivanju stola.";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;
                }
            }
        }
    }

} 
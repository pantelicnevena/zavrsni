<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/24/14
 * Time: 1:38 PM
 */

class Kategorija  implements JsonSerializable{
    private $kategorijaID;
    private $nazivKategorije;

    function __construct($kategorijaID, $nazivKategorije)
    {
        $this->kategorijaID = $kategorijaID;
        $this->nazivKategorije = $nazivKategorije;
    }

    /**
     * @param mixed $kategorijaID
     */
    public function setKategorijaID($kategorijaID)
    {
        $this->kategorijaID = $kategorijaID;
    }

    /**
     * @return mixed
     */
    public function getKategorijaID()
    {
        return $this->kategorijaID;
    }

    /**
     * @param mixed $nazivKategorije
     */
    public function setNazivKategorije($nazivKategorije)
    {
        $this->nazivKategorije = $nazivKategorije;
    }

    /**
     * @return mixed
     */
    public function getNazivKategorije()
    {
        return $this->nazivKategorije;
    }

    public function expose(){
        return get_object_vars($this);
    }

    function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->kategorijaID ." ". $this->nazivKategorije;
    }

    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }

    public static function vratiSveKategorije(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("kategorija", "*", null, null, null, null, null);
        $niz = array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
        return false;
    }

    public static function vratiKategoriju($kategorijaID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("kategorija", "*", null, null, null, "kategorijaID = ".$kategorijaID, null);
        $niz=array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
    }

    public function izmeniKategoriju($kategorijaID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $podaci_json = Flight::get("json_podaci");
        $podaci = json_decode ($podaci_json);
        if ($podaci == null){
            $odgovor["poruka"] = "Niste prosledili podatke";
            $json_odgovor = json_encode ($odgovor);
            echo $json_odgovor;
        } else {
            if (!property_exists($podaci,'nazivKategorije')){
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
                if ($db->update("kategorija", $kategorijaID, array('nazivKategorije'), array($podaci->nazivKategorije))){
                    $odgovor["poruka"] = "Kategorija je uspešno izmenjen";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    //echo $json_odgovor;
                    return true;

                } else {
                    $odgovor["poruka"] = "Došlo je do greške pri izmeni kategorije";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;
                }

            }
        }
    }

    public function obrisiKategoriju($kategorijaID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        if ($db->delete("kategorija", array("kategorijaID"),array($kategorijaID))){
            $odgovor["poruka"] = "Kategorija je uspešno izbrisana.";
            $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;
        } else {
            $odgovor["poruka"] = "Došlo je do greške prilikom brisanja kategorije.";
            $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;

        }
    }

    public function unesiKategoriju(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $podaci_json = Flight::get("json_podaci");
        $podaci = json_decode ($podaci_json);
        if ($podaci == null){
            $odgovor["poruka"] = "Niste prosledili podatke";
            $json_odgovor = json_encode ($odgovor);
            echo $json_odgovor;
        } else {
            if (!property_exists($podaci,'nazivKategorije')){
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
                if ($db->insert("kategorija", "nazivKategorije", array($podaci_query["nazivKategorije"]))){
                    $odgovor["poruka"] = "Kategorija je uspešno ubacena";
                    $json_odgovor = json_encode ($odgovor, JSON_UNESCAPED_UNICODE);
                    //echo $json_odgovor;
                    return false;
                } else {
                    $odgovor["poruka"] = "Došlo je do greške pri ubacivanju kategorije";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;
                }
            }
        }
    }


} 
<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/23/14
 * Time: 2:44 PM
 */

class Artikal implements JsonSerializable{
    private $artikalID;
    private $nazivArtikla;
    private $ambalaza;
    private $rokTrajanja;
    private $stanjeNaZalihama;
    private $cena;
    private $distributerID;
    private $kategorijaID;

    function __construct($artikalID, $nazivArtikla, $ambalaza, $rokTrajanja, $stanjeNaZalihama, $cena, $distributerID, $kategorijaID)
    {
        $this->artikalID = $artikalID;
        $this->nazivArtikla = $nazivArtikla;
        $this->ambalaza = $ambalaza;
        $this->rokTrajanja = $rokTrajanja;
        $this->stanjeNaZalihama = $stanjeNaZalihama;
        $this->cena = $cena;
        $this->distributerID = $distributerID;
        $this->kategorijaID = $kategorijaID;
    }

    /**
     * @param mixed $ambalaza
     */
    public function setAmbalaza($ambalaza)
    {
        $this->ambalaza = $ambalaza;
    }

    /**
     * @return mixed
     */
    public function getAmbalaza()
    {
        return $this->ambalaza;
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
     * @param mixed $cena
     */
    public function setCena($cena)
    {
        $this->cena = $cena;
    }

    /**
     * @return mixed
     */
    public function getCena()
    {
        return $this->cena;
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
     * @param mixed $nazivArtikla
     */
    public function setNazivArtikla($nazivArtikla)
    {
        $this->nazivArtikla = $nazivArtikla;
    }

    /**
     * @return mixed
     */
    public function getNazivArtikla()
    {
        return $this->nazivArtikla;
    }

    /**
     * @param mixed $rokTrajanja
     */
    public function setRokTrajanja($rokTrajanja)
    {
        $this->rokTrajanja = $rokTrajanja;
    }

    /**
     * @return mixed
     */
    public function getRokTrajanja()
    {
        return $this->rokTrajanja;
    }

    /**
     * @param mixed $stanjeNaZalihama
     */
    public function setStanjeNaZalihama($stanjeNaZalihama)
    {
        $this->stanjeNaZalihama = $stanjeNaZalihama;
    }

    /**
     * @return mixed
     */
    public function getStanjeNaZalihama()
    {
        return $this->stanjeNaZalihama;
    }

    public function expose(){
        return get_object_vars($this);
    }

    function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->nazivArtikla ." ". $this->cena;
    }

    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }


    public static function vratiSveArtikle(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("artikal", "*", "kategorija", "kategorijaID", "kategorijaID", null, "nazivArtikla");
        $niz = array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
    }

    public static function vratiArtikal($artikalID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $db->select("artikal", "*", null, null, null, "artikalID = ".$artikalID, null);
        $niz=array();
        while ($red=$db->getResult()->fetch_object()){
            $niz[] = $red;
        }
        $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
    }

    public function izmeniArtikal($artikalID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $podaci_json = Flight::get("json_podaci");
        $podaci = json_decode ($podaci_json);
        if ($podaci == null){
            $odgovor["poruka"] = "Niste prosledili podatke";
            $json_odgovor = json_encode ($odgovor);
            echo $json_odgovor;
        } else {
            if (!property_exists($podaci,'artikalID')||!property_exists($podaci,'nazivArtikla')||!property_exists($podaci,'ambalaza')||!property_exists($podaci,'rokTrajanja')||!property_exists($podaci,'stanjeNaZalihama')||!property_exists($podaci,'cena')||!property_exists($podaci,'distributerID')||!property_exists($podaci,'kategorijaID')){
                $odgovor["poruka"] = "Niste prosledili korektne podatke";
                $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
            } else {
                $podaci_query = array();
                foreach ($podaci as $k=>$v){
                    $v = "'".$v."'";
                    $podaci_query[$k] = $v;
                }
                if ($db->update("artikal", $artikalID, array('nazivArtikla', 'ambalaza', 'rokTrajanja', 'stanjeNaZalihama', 'cena', 'distributerID', 'kategorijaID'), array($podaci->nazivArtikla, $podaci->ambalaza, $podaci->rokTrajanja, $podaci->stanjeNaZalihama, $podaci->cena, $podaci->distributerID, $podaci->kategorijaID))){
                    $odgovor["poruka"] = "Artikal je uspešno izmenjen";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    //echo $json_odgovor;

                } else {
                    $odgovor["poruka"] = "Došlo je do greške pri izmeni artikla";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                }

            }
        }
    }

    public function obrisiArtikal($artikalID){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        if ($db->delete("artikal", array("artikalID"),array($artikalID))){
            $odgovor["poruka"] = "Ponuda je uspešno izbrisana";
            $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
        } else {
            $odgovor["poruka"] = "Došlo je do greške prilikom brisanja ponude";
            $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
        }
    }

    public function unesiArtikal(){
        header ("Content-Type: application/json; charset=utf-8");
        $db = Flight::db();
        $podaci_json = Flight::get("json_podaci");
        $podaci = json_decode ($podaci_json);
        if ($podaci == null){
            $odgovor["poruka"] = "Niste prosledili podatke";
            $json_odgovor = json_encode ($odgovor);
            echo $json_odgovor;
        } else {
            if (!property_exists($podaci,'nazivArtikla')||!property_exists($podaci,'ambalaza')||!property_exists($podaci,'rokTrajanja')||!property_exists($podaci,'stanjeNaZalihama')||!property_exists($podaci,'cena')||!property_exists($podaci,'distributerID')||!property_exists($podaci,'kategorijaID')){
                $odgovor["poruka"] = "Niste prosledili korektne podatke";
                $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;

            } else {
                $podaci_query = array();
                foreach ($podaci as $k=>$v){
                    $v = "'".$v."'";
                    $podaci_query[$k] = $v;
                }
                if ($db->insert("artikal", "nazivArtikla, ambalaza, rokTrajanja, stanjeNaZalihama, cena, distributerID, kategorijaID", array($podaci_query["nazivArtikla"], $podaci_query["ambalaza"], $podaci_query["rokTrajanja"], $podaci_query["stanjeNaZalihama"], $podaci_query["cena"], $podaci_query["distributerID"], $podaci_query["kategorijaID"]))){
                    $odgovor["poruka"] = "Novost je uspešno ubacena";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    //echo $json_odgovor;
                    return false;
                } else {
                    $odgovor["poruka"] = "Došlo je do greške pri ubacivanju novosti";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;
                }
            }
        }
    }

}
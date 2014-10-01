<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/23/14
 * Time: 2:09 PM
 */


    class Konobar implements JsonSerializable{
        private $konobarID;
        private $ime;
        private $prezime;
        private $godinaRodjenja;
        private $mestoRodjenja;
        private $korisnickoIme;
        private $korisnickaSifra;
        private $role;
        private $slika;

        function __construct($konobarID, $ime, $prezime, $godinaRodjenja, $mestoRodjenja, $korisnickoIme, $korisnickaSifra, $role, $slika)
        {
            $this->konobarID = $konobarID;
            $this->ime = $ime;
            $this->prezime = $prezime;
            $this->godinaRodjenja = $godinaRodjenja;
            $this->mestoRodjenja = $mestoRodjenja;
            $this->korisnickoIme = $korisnickoIme;
            $this->korisnickaSifra = $korisnickaSifra;
            $this->role = $role;
            $this->slika = $slika;
        }

        /**
         * @param mixed $godinaRodjenja
         */
        public function setGodinaRodjenja($godinaRodjenja)
        {
            $this->godinaRodjenja = $godinaRodjenja;
        }

        /**
         * @return mixed
         */
        public function getGodinaRodjenja()
        {
            return $this->godinaRodjenja;
        }

        /**
         * @param mixed $ime
         */
        public function setIme($ime)
        {
            $this->ime = $ime;
        }

        /**
         * @return mixed
         */
        public function getIme()
        {
            return $this->ime;
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
         * @param mixed $korisnickaSifra
         */
        public function setKorisnickaSifra($korisnickaSifra)
        {
            $this->korisnickaSifra = $korisnickaSifra;
        }

        /**
         * @return mixed
         */
        public function getKorisnickaSifra()
        {
            return $this->korisnickaSifra;
        }

        /**
         * @param mixed $korisnickoIme
         */
        public function setKorisnickoIme($korisnickoIme)
        {
            $this->korisnickoIme = $korisnickoIme;
        }

        /**
         * @return mixed
         */
        public function getKorisnickoIme()
        {
            return $this->korisnickoIme;
        }

        /**
         * @param mixed $mestoRodjenja
         */
        public function setMestoRodjenja($mestoRodjenja)
        {
            $this->mestoRodjenja = $mestoRodjenja;
        }

        /**
         * @return mixed
         */
        public function getMestoRodjenja()
        {
            return $this->mestoRodjenja;
        }

        /**
         * @param mixed $prezime
         */
        public function setPrezime($prezime)
        {
            $this->prezime = $prezime;
        }

        /**
         * @return mixed
         */
        public function getPrezime()
        {
            return $this->prezime;
        }

        /**
         * @param mixed $role
         */
        public function setRole($role)
        {
            $this->role = $role;
        }

        /**
         * @return mixed
         */
        public function getRole()
        {
            return $this->role;
        }

        /**
         * @param mixed $slika
         */
        public function setSlika($slika)
        {
            $this->slika = $slika;
        }

        /**
         * @return mixed
         */
        public function getSlika()
        {
            return $this->slika;
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

        public static function vratiSveKonobare(){
            header ("Content-Type: application/json; charset=utf-8");
            $db = Flight::db();
            $db->select("konobar", "*", null, null, null, null, null);
            $niz = array();
            while ($red=$db->getResult()->fetch_object()){
                $niz[] = $red;
            }
            $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
            return indent($json_niz);
        }

        public static function vratiKonobara($konobarID){
            header ("Content-Type: application/json; charset=utf-8");
            $db = Flight::db();
            $db->select("konobar", "*", null, null, null, "konobarID = ".$konobarID, null);
            $niz=array();
            while ($red=$db->getResult()->fetch_object()){
                $niz[] = $red;
            }
            $json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
            echo indent($json_niz);
        }

        public function izmeniKonobara($konobarID){
            header ("Content-Type: application/json; charset=utf-8");
            $db = Flight::db();
            $podaci_json = Flight::get("json_podaci");
            $podaci = json_decode ($podaci_json);
            if ($podaci == null){
                $odgovor["poruka"] = "Niste prosledili podatke";
                $json_odgovor = json_encode ($odgovor);
                echo $json_odgovor;
            } else {
                if (!property_exists($podaci,'konobarID')||!property_exists($podaci,'prezime')||!property_exists($podaci,'godinaRodjenja')||!property_exists($podaci,'mestoRodjenja')||!property_exists($podaci,'korisnickoIme')||!property_exists($podaci,'korisnickaSifra')||!property_exists($podaci,'role')||!property_exists($podaci,'slika')){
                    $odgovor["poruka"] = "Niste prosledili korektne podatke";
                    $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                    echo $json_odgovor;
                    return false;

                } else {
                    $podaci_query = array();
                    $odgovor["proba"]="uspesno, cekaj.";
                    foreach ($podaci as $k=>$v){
                        $v = "'".$v."'";
                        $podaci_query[$k] = $v;
                    }
                    if ($db->update("konobar", $konobarID, array('ime', 'prezime', 'godinaRodjenja', 'mestoRodjenja', 'korisnickoIme', 'korisnickaSifra', 'role', 'slika'), array($podaci->ime, $podaci->prezime, $podaci->godinaRodjenja, $podaci->mestoRodjenja, $podaci->korisnickoIme, $podaci->korisnickaSifra, $podaci->role, $podaci->slika))){
                        $odgovor["poruka"] = "Konobar je uspešno izmenjen";
                        $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                        //echo $json_odgovor;
                        return true;

                    } else {
                        $odgovor["poruka"] = "Došlo je do greške pri izmeni konobara";
                        $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                        echo $json_odgovor;
                        return false;
                    }

                }
            }
        }

        public function obrisiKonobara($konobarID){
            header ("Content-Type: application/json; charset=utf-8");
            $db = Flight::db();
            if ($db->delete("konobar", array("konobarID"),array($konobarID))){
                $odgovor["poruka"] = "Konobar je uspešno izbrisan";
                $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;
            } else {
                $odgovor["poruka"] = "Došlo je do greške prilikom brisanja konobara";
                $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;

            }
        }

        public function unesiKonobara(){
            header ("Content-Type: application/json; charset=utf-8");
            $db = Flight::db();
            $podaci_json = Flight::get("json_podaci");
            $podaci = json_decode ($podaci_json);
            if ($podaci == null){
                $odgovor["poruka"] = "Niste prosledili podatke";
                $json_odgovor = json_encode ($odgovor);
                echo $json_odgovor;
            } else {
                if (!property_exists($podaci,'prezime')||!property_exists($podaci,'godinaRodjenja')||!property_exists($podaci,'mestoRodjenja')||!property_exists($podaci,'korisnickoIme')||!property_exists($podaci,'korisnickaSifra')||!property_exists($podaci,'role')||!property_exists($podaci,'slika')){
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
                    if ($db->insert("konobar", "ime, prezime, godinaRodjenja, mestoRodjenja, korisnickoIme, korisnickaSifra, role, slika", array($podaci_query["ime"], $podaci_query["prezime"], $podaci_query["godinaRodjenja"], $podaci_query["mestoRodjenja"], $podaci_query["korisnickoIme"], $podaci_query["korisnickaSifra"], $podaci_query["role"], $podaci_query["slika"]))){
                        $odgovor["poruka"] = "Ponuda je uspešno ubacena";
                        $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                        //echo file_get_contents("/rest/konobar/1000");
                        //echo $json_odgovor;
                        return false;
                    } else {
                        $odgovor["poruka"] = "Došlo je do greške pri ubacivanju ponude";
                        $json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
                        echo $json_odgovor;
                        return false;
                    }
                }
            }
        }

    }
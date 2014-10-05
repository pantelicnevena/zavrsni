<?php
include("../Konekcija.php");
$porudzbina = json_decode(file_get_contents('php://input')); //get porudzbina
$datumPorudzbine = $porudzbina->datumPorudzbine;
$razduzeno = $porudzbina->razduzeno;
$napravljena = $porudzbina->napravljena;
$konobarID = $porudzbina->konobarID;
$stoID = $porudzbina->stoID;
$ukupnaVrednost = 0;

mysqli_query($db,
    "insert into porudzbina (datumPorudzbine, razduzeno, napravljena, konobarID, stoID, ukupnaVrednost) values ('$datumPorudzbine', '$razduzeno', '$napravljena', '$konobarID', '$stoID', '$ukupnaVrednost')");


//print_r(mysql_insert_id());
print(mysql_insert_id());
?>
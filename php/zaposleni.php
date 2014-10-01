<?php
include("../Konekcija.php");

$konobar = json_decode(file_get_contents('php://input'));  //get zaposleni from
$korisnickoIme = $konobar->korisnickoIme;
$korisnickaSifra = $konobar->korisnickaSifra;

$ses_sql = mysqli_query($db,"select * from konobar where korisnickoIme='$korisnickoIme' and korisnickaSifra ='$korisnickaSifra'");
$row = mysqli_fetch_array($ses_sql , MYSQLI_ASSOC);
$count = mysqli_num_rows($ses_sql);

if ($count == 1){
    session_start();
    $konobar->uid = $_SESSION['uid'];
    $konobar->id = $row['konobarID'];
    $konobar->role = $row['role'];
    $_SESSION['uid']=uniqid('ang_');
    $_SESSION['id'] = $konobar->id;
    $_SESSION['role'] = $konobar->role;
    print json_encode($konobar);
}

/*if($korisnickoIme=='admin' && $korisnickaSifra=='admin'){

    $ses_sql = mysqli_query($db,"select * from konobar where korisnickoIme='nepa' and korisnickaSifra ='nepa'");
    $row = mysqli_fetch_array($ses_sql , MYSQLI_ASSOC);
    $count = mysqli_num_rows($ses_sql);


}*/
?>
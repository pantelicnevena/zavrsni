<?php
    include("../Konekcija.php");

    session_start();
    if( isset($_SESSION['id']) ) {
        $id = $_SESSION['id'];
        $ses_sql = mysqli_query($db,"select * from konobar where konobarID ='$id'");
        $row = mysqli_fetch_array($ses_sql , MYSQLI_ASSOC);
        $role = $row['role'];
        if ($role == 4) print $role;
    }
?>
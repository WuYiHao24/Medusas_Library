<?php

if (isset($_GET['id'])) {
    require_once("../../things/Connect.php");
	$table = "Utente";
	

    $id = $_GET['id'];
    $sql = "DELETE FROM $table WHERE id=$id";
    $conn->query($sql);

    header("Location: dashboardUtenti.php");
    die(); 
}else {
    header("Location: dashboardUtenti.php");
    die();
}

?>
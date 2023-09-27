<?php 
    $table = "Utente";
    require_once("../../things/Connect.php");
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $classe = $_POST['classe'];
    $ruolo = $_POST['ruolo'];
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_BCRYPT);

    //echo $nome." ".$cognome." ".$email." ".$classe." ".$ruolo." ".$password;


    $sql = "INSERT INTO $table (`Nome`, `Cognome`, `Email`, `Classe`, `Utenza`, `Password`) VALUES ('$nome','$cognome','$email','$classe','$ruolo','$password')";
    $conn->query($sql);
    $conn->close();
    header("Location: dashboardUtenti.php");
?>
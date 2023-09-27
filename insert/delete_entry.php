<?php
session_start();
require_once("../autenticazione/cookies.php");

if(isset($_POST['isbn'])){
    $isbn = $_POST['isbn'];
    
    //$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
    require_once("../things/Connect.php");

    if (mysqli_connect_error()){
        die('Errore nella connessione al database');
     }
    
    //Eliminazione file copertina
    else{
        $query = "SELECT Copertina FROM Opera WHERE ISBN = $isbn";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $file_path = "../" . $row['Copertina'];
        //echo $file_path;
        mysqli_free_result($result);
     
        if (file_exists($file_path)) {
         unlink($file_path);
        }

        //Eliminazione dati libro da database e reset autoincrement per corretto funzionamento "Ultime Aggiunte | Home"

        $query2 = "DELETE FROM Opera WHERE ISBN = '$isbn'";
         mysqli_query($conn, $query2);
         
         $query3 = "ALTER TABLE `Opera` AUTO_INCREMENT = 0";
         mysqli_query($conn, $query3);
         
         mysqli_close($conn);

        header("Location: index.php");
        exit();


        // DA FARE!!!! Gestione errori con sessione







        //  if(mysqli_query($conn, $sql) === TRUE){
        //      $_SESSION['success_msg'] =  "Libro rimosso dal database"; 
        //      header("Location: index.php");
        //      exit(); }
         
        //      else{
        //      $_SESSION['unsuccess_msg'] = "ISBN non presente nel sistema";
        //      header("Location: index.php");
        //      exit();
        //  }
    
    
    
    
    
    //rimozione libro da database
}}
else{
    echo "";
}
?>
<?php 
    session_start();
    require_once("../things/Connect.php");

    $user_email = $_SESSION['email'];
    $oggetto = addslashes($_POST['oggetto']);
    $messaggio = addslashes($_POST['messaggio']);

    if(!empty($_FILES['screenshot'])) { 

    //Recupera i dati del file inviato
    $file = $_FILES['screenshot'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    // Estrae l'estensione del file
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));

    // Crea un nome univoco per il file
    $file_name_new = str_replace(' ', '') . uniqid() . '.' . $file_ext;

    // Specifica la directory di destinazione per il file
    $file_destination = 'imgSegnalazioni/' . $file_name_new;

    
    // Controlla se ci sono errori durante il caricamento del file
    if ($file_error === 0) {
        // Verifica che il file sia di un formato supportato
        $allowed = array('jpg', 'jpeg', 'png');
        if (in_array($file_ext, $allowed)) {
            // Verifica che la dimensione del file non superi un limite specificato
            if ($file_size <= 5000000) {
                // Carica il file
                move_uploaded_file($file_tmp, $file_destination);
                $imgSegn = "imgSegnalazioni/" . $file_name_new; 
                $sql = "INSERT INTO Segnalazione (userEmail, Oggetto, Messaggio, imgSegn) VALUES ('$user_email', '$oggetto', '$messaggio', '$imgSegn')";
                mysqli_query($conn,$sql);
                echo '<center><h1 style="color: green; font-weight:bold">Segnalazione e screenshot inviati con successo</h1></center>';
                echo "<meta http-equiv='refresh' content='2;url=../index.php'>";
            } else {
                echo '<center><h1 style="color: red; font-weight:bold">Il file è troppo grande dimensione massima 5MB</h1></center>';
                echo "<meta http-equiv='refresh' content='2;url=segnalazione.html'>";
            }
        } else {
                echo '<center><h1 style="color: red; font-weight:bold">Il file non è supportato caricare solo file di formato: jpg, jpeg o png</h1></center>';
                echo "<meta http-equiv='refresh' content='2;url=segnalazione.html'>";
        }
    } else {
        $sql = "INSERT INTO Segnalazione (userEmail, Oggetto, Messaggio) VALUES ('$user_email', '$oggetto', '$messaggio')";
        mysqli_query($conn,$sql);
        echo '<center><h1 style="color: green; font-weight:bold">Segnalazione inviata con successo</h1></center>';
        echo "<meta http-equiv='refresh' content='2;url=../index.php'>";
    }

    }

?>
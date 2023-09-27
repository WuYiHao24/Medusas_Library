<?php
session_start();
require_once("../autenticazione/cookies.php");
$email = $_SESSION['email'];

require_once("../things/Connect.php");

if (isset($_POST['propicIns'])) {
    //Recupera i dati del file inviato
    $file = $_FILES['image'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    // Estrae l'estensione del file
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));

    // Crea un nome univoco per il file
    $file_name_new = uniqid() . '.' . $file_ext;

    // Specifica la directory di destinazione per il file
    $file_destination = '../propics/' . $file_name_new;

    // Controlla se ci sono errori durante il caricamento del file
    if ($file_error === 0) {
        // Verifica che il file sia di un formato supportato
        $allowed = array('jpg', 'jpeg', 'png');
        if (in_array($file_ext, $allowed)) {
            // Verifica che la dimensione del file non superi un limite specificato
            if ($file_size <= 5000000) {
                // Carica il file
                move_uploaded_file($file_tmp, $file_destination);
                echo 'Il file ' . $file_name . ' è stato caricato con successo.';
            } else {
                echo 'Il file ' . $file_name . ' è troppo grande. Il limite massimo è 5 MB.';
            }
        } else {
            echo 'Il file ' . $file_name . ' non è supportato. I formati supportati sono: jpg, jpeg e png.';
        }
    } else {
        echo 'Si è verificato un errore durante il caricamento del file ' . $file_name . '.';
    }
    $propic = "propics/" . $file_name_new;

    $sql = "UPDATE `Utente` SET propic = '$propic' WHERE `Utente`.`Email` = '$email'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_msg'] = "Immagine cambiata con successo.";
        header("Location: Edit_Profile.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


?>
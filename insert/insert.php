<?php
session_start();
require_once("../autenticazione/cookies.php");
if (isset($_POST['btn'])) {
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
    $file_destination = '../img/' . $file_name_new;

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

    $titolo = $_POST['titolo'];
    $autore = $_POST['autore'];
    $casa_editrice = $_POST['casa_editrice'];
    $isbn = $_POST['isbn'];
    $genere = $_POST['genere'];
    $descrizione = addslashes($_POST['descrizione']);
    $anno_pubblicazione = $_POST['anno_pubblicazione'];
    $copertina = "img/" . $file_name_new;
    //$copertina = "img/default.png";
    require_once("../things/Connect.php");

    $sql = "INSERT INTO Opera (`ISBN`, `Nome`, `Autore`, `Genere`, `Descrizione`, `Copertina`, `CasaEditrice`, `AnnoPubblicazione`)
    VALUES ($isbn, '$titolo', '$autore', '$genere', '$descrizione', '$copertina', '$casa_editrice', $anno_pubblicazione)";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_msg'] = "Libro aggiunto al database";
        //header("Location: index.php");
        //exit(); 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
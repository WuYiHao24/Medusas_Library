<?php
session_start();



if (isset($_POST['btnOpera'])) {

    require_once("../../things/Connect.php");
    $titolo = $_POST['titolo'];
    $autore = $_POST['autore'];
    $casa_editrice = $_POST['casaed'];
    $isbn = $_POST['isbn'];
    $genere = $_POST['genere'];
    $descrizione = addslashes($_POST['desc']);
    $anno_pubblicazione = $_POST['annopub'];
    
    $copie = $_POST['qty'];


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
    $file_name_new = str_replace(' ', '', $titolo) . uniqid() . '.' . $file_ext;

    // Specifica la directory di destinazione per il file
    $file_destination = '../../img/' . $file_name_new;

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

    $copertina = "img/" . $file_name_new;
    
    if ($stmt = $conn->prepare('SELECT ISBN FROM Opera WHERE ISBN = ?')) {
        $stmt->bind_param('i', $isbn);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['error_msg'] = "Errore: il DataBase ha già i dati sul libro. Impossibile inserire Opera. Si prega di passare alla pagina per inserire Copia/e.";
            header("Location: dashboardLibri.php");
            //exit();
        } else {
            $sql = "INSERT INTO Opera (`ISBN`, `Nome`, `Autore`, `Genere`, `Descrizione`, `Copertina`, `CasaEditrice`, `AnnoPubblicazione`)
            VALUES ($isbn, '$titolo', '$autore', '$genere', '$descrizione', '$copertina', '$casa_editrice', $anno_pubblicazione)";

            $sql2 = "INSERT INTO copiaLibro (`ISBN`, `Stato`) VALUES ($isbn, '1')";

            if ($conn->query($sql) === TRUE) {
                for ($i = 0; $i < $copie; $i++) {
                    $conn->query($sql2);
                }
                $_SESSION['success_msg'] = "Dati sul libro e relativa/e copia/e aggiunto al database";
                header("Location: dashboardLibri.php");
                //exit(); 
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo '<h2 style="color: red;">Errore, operazione fallita</h2>';
    }

    $conn->close();

} else if (isset($_POST['btnCopia'])) {
    require_once("../../things/Connect.php");

    $isbn = $_POST['isbn'];
    $copie = $_POST['qty'];


    if ($stmt = $conn->prepare('SELECT ISBN FROM Opera WHERE ISBN = ?')) {
        $stmt->bind_param('i', $isbn);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) > 0) {
            $sql = "INSERT INTO copiaLibro (`ISBN`, `Stato`) VALUES ($isbn, '1')";

            for ($i = 0; $i < $copie; $i++) {
                $conn->query($sql);
            }
            $_SESSION['success_msg'] = "Copia/e libro aggiunto al database";
            header("Location: dashboardLibri.php");
            //exit(); 
        } else {
            $_SESSION['error_msg'] = "Errore: il DataBase non ha i dati sul libro. Impossibile inserire copia/e.";
            header("Location: dashboardLibri.php");
            //exit();
        }
    } else {
        echo '<h2 style="color: red;">Errore, operazione fallita</h2>';
    }

    $conn->close();
}
?>
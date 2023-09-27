<?php
session_start();

if (isset($_POST['check'])) {
    // Connessione al database
    require_once("../../things/Connect.php");
    $isbn = $_POST['isbn-check'];

    // Controllo se il libro esiste già nel database
    if ($stmt = $conn->prepare('SELECT * FROM Opera WHERE ISBN = ?')) {
        $stmt->bind_param('s', $isbn);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['libroEsiste'] = true;
            header("Location: aggiungiLibro.php");
        } else {
            $_SESSION['libroEsiste'] = false;
            header("Location: aggiungiLibro.php");
        }
    } else {
        echo "Errore durante controllo: " . $conn->error;
    }

    // Chiudo la connessione al database
    $conn->close();
}
?>
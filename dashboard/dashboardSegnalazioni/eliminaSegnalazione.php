<?php
// Verifica se è stato fornito un parametro "id" nell'URL
if (isset($_GET['id'])) {
    $idSegnalazione = $_GET['id'];
  
    // Connessione al database
    require_once("../../things/Connect.php");
  
    // Query per eliminare la segnalazione e selezione path immagine
    $query = "SELECT imgSegn FROM Segnalazione WHERE idSegnalazione = $idSegnalazione";
    $sql = "DELETE FROM Segnalazione WHERE idSegnalazione = $idSegnalazione";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $file_path = "../../segnalazione/" . $row['imgSegn'];
    mysqli_free_result($result);

    try {
        // Esecuzione della query di eliminazione
        $result = $conn->query($sql);
  
        // Controllo se la query ha avuto successo
        if ($result) {
            // Eliminazione eventuale screenshot
            if (file_exists($file_path)) {
                    unlink($file_path);
                }
            echo '<center><h1 style="color:green; font-weight=bold;">Segnalazione eliminata con successo</h1></center>';
            echo '<meta http-equiv=\'refresh\' content=\'2;url=dashboardSegnalazioni.php\'>';
        } else {
            echo '<center><h1 style="color:red; font-weight=bold;">Errore durante l\'eliminazione della segnalazione</h1></center>';
            echo "<meta http-equiv=\'refresh\' content=\'2;url=dettaglio.php?id=".$idSegnalazione."\'>";
        }
    } catch (PDOException $e) {
        echo '<center><h1 style="color:red; font-weight=bold;">Errore durante l\'esecuzione della query:</h1></center>' . $e->getMessage();
        echo "<meta http-equiv=\'refresh\' content=\'2;url=dettaglio.php?id=".$idSegnalazione."\'>";
    }
} else {
    echo '<center><h1 style="color:red; font-weight=bold;">Parametro id mancante nella richiesta</h1></center>';
    echo '<meta http-equiv=\'refresh\' content=\'2;url=dashboardSegnalazioni.php\'>';
}
?>
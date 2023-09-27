<?php
require_once("Connect.php");

$conn->query("UPDATE Prenotazione SET Stato = 2 WHERE Fine < CURDATE() AND Stato != 4 AND Stato != 0");
$conn->query("UPDATE Utente, Prenotazione SET `punteggio` = punteggio - 5 WHERE Prenotazione.Stato = 2 AND Prenotazione.Email = Utente.Email");
?>
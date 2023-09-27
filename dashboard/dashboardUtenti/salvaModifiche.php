<?php
// Connessione al database
require_once("../../things/Connect.php");

// Recupero i dati inviati dal form
$id = $_POST['id'];
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$email = $_POST['email'];
$classe = $_POST['classe'];
$ruolo = $_POST['ruolo'];
$password = $_POST['password'];

// Controlla se l'utente ha inserito una nuova password
if (!empty($password)) {
	
	// Aggiorna la password e gli altri campi nel database 
	$password_hash = password_hash($password, PASSWORD_BCRYPT);
	$sql = "UPDATE Utente SET Nome='$nome', Cognome='$cognome', Email='$email', Classe='$classe', Utenza='$ruolo', Password='$password_hash' WHERE id=$id";

	if ($conn->query($sql) === TRUE) {
		header("Location: dashboardUtenti.php");
	} else {
		echo "Errore durante il salvataggio delle modifiche: " . $conn->error;
	}
	
  } else {
	// L'utente non ha inserito una nuova password, quindi si aggiornano gli altri campi e non la password nel database
	$sql = "UPDATE Utente SET Nome='$nome', Cognome='$cognome', Email='$email', Classe='$classe', Utenza='$ruolo' WHERE id=$id";

	if ($conn->query($sql) === TRUE) {
		header("Location: dashboardUtenti.php");
	} else {
		echo "Errore durante il salvataggio delle modifiche: " . $conn->error;
	}
  }

$conn->close();
?>
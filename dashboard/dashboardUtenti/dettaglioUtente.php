<!DOCTYPE html>
<html>

<head>
	<title>Gestione Utente</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="dettaglioUtenti.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../things/colors.css">
	<link rel="stylesheet" href="../../prenotazione/prenotazione.css">
	<link rel="stylesheet" href="../../nav/nav.css">

	<!--script per importare parti di codice-->
	<script src="https://code.jquery.com/jquery-1.12.2.js"></script>
</head>

<body>

	<div id="nav-placeholder"></div>
	<script>
		$(function () {
			$("#nav-placeholder").load("../../nav/nav.php");
		});
	</script>
	<div class="container">
		<?php
		// Connessione al database
		require_once("../../things/Connect.php");
		$table = "Prenotazione";
        $table1 = "copiaLibro";
        $table2 = "Opera";
		

		// Recupero l'ID dell'utente selezionato dalla pagina precedente
		$id = $_GET['id'];

		// Recupero i dati dell'utente dal database
		$sql = "SELECT * FROM Utente WHERE id = $id";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$nome = $row["Nome"];
			$cognome = $row["Cognome"];
			$email = $row["Email"];
			$classe = $row["Classe"];
			$ruolo = $row["Utenza"];
			$propic = $row["propic"];
		} else {
			echo "Nessun utente trovato";
		}

		echo "
		<div class='user-details'>
			<img src='../../" . $propic . "'>
			<div class='user-status'>
			<h2>" . $nome . " " . $cognome . "</h2>
			<br>
			<h3>" . $email . " • " . $classe . " • Punti: " . $row['punteggio'] . "</h3>
			</div>
			</div>

		";

		if ($q = $conn->prepare('SELECT Email FROM Utente WHERE id=?')) {
			$q->bind_param('i', $id);
			$q->execute();
			$result = $q->get_result();
			$email = $result->fetch_assoc();
		}
		foreach ($conn->query("SELECT idPrenotazione, Copertina, $table.idCopia, Inizio, Fine, Autore, Nome, CasaEditrice, $table.Stato FROM $table, $table1, $table2 WHERE $table1.idCopia = $table.idCopia AND $table2.ISBN = $table1.ISBN and $table.Email = '$email[Email]' ORDER BY $table.idPrenotazione DESC") as $row) {
			if ($row["Stato"] == 0) {
				$stato = "In Prenotazione";
				$color = "#ff7600";
			} else if($row["Stato"] == 1){
				$stato = "Prenotato";
				$color = "green";
			}else if($row["Stato"] == 2){
				$stato = "In ritardo";
				$color = "red";
			}else if($row['Stato'] == 3){
				$stato = "In consegna";
				$color = "#ff7600";
			}else if($row['Stato'] == 4){
				$stato = "Terminata";
				$color = "#686868";
			}else if($row['Stato'] == 5){
				$stato = "Eliminata";
				$color = "red";
			}


			echo
				"<div class='book-container'>
            <div class='book-link'>
                <img src='../../" . $row['Copertina'] . "' alt=''  class='book-cover' width='160px'>
                <div class='book-section'>
                    <h3>" . $row['Nome'] . "</h3>
                    <div class='info-release'><h5>" . $row['Autore'] . "</h5>  <h5>" . $row['CasaEditrice'] . "</h5>  <h5>Stato:</h5> <h5 class='status' style='color: $color'>" . $stato . "</h5></div>
                    <form action=''><span>inizio prenotazione:</span><span>" . $row['Inizio'] . "</span></form>
                    <form action=''><span>fine prenotazione:</span><span>" . $row['Fine'] . "</span></form>
                    <form action='dettaglioPrenotazione.php?id=" . $row['idPrenotazione'] . "' method='post'><button name='apri-dettaglio' style='margin-top: 20px; width: 20vh;'>Gestisci</button></form>
				</div>
            </div>
            </div>";

		}
		?>



	</div>
</body>

</html>
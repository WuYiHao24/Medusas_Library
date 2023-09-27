<!DOCTYPE html>
<html>
<head>
	<title>Modifica libro</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<h2>Modifica libro</h2>
		<?php
		// Connessione al database
		$table = "Opera";
		require_once("../../things/Connect.php");
		
		// Recupero l'ID dell'utente selezionato dalla pagina precedente
		$id = $_GET['id'];
		
		// Recupero i dati dell'utente dal database
		$sql = "SELECT * FROM $table WHERE ISBN = $id";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$nome = $row["Nome"];
			$autore = $row["Autore"];
			$genere = $row["Genere"];
			$desc = $row["Descrizione"];
			$casaed = $row["CasaEditrice"];
		} else {
			echo "Nessun libro trovato";
		}
		
		// Chiudo la connessione al database
		$conn->close();
		?>
		<form action="salvaModifiche.php" method="post">
			<div class="form-group">
				<label for="nome">Nome:</label>
				<input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>">
			</div>
			<div class="form-group">
				<label for="cognome">Cognome:</label>
				<input type="text" class="form-control" id="cognome" name="cognome" value="<?php echo $autore; ?>">
			</div>
			<div class="form-group">
				<label for="email">Email:</label>
				<textarea class="form-control" id="email" name="email" value="<?php echo $desc; ?>">
			</div>
			<div class="form-group">
				<label for="classe">Classe:</label>
				<input type="" class="form-control" id="classe" name="classe" value="<?php echo $casaed; ?>">
			</div>
			<div class="form-group">
				<label for="ruolo">Ruolo:</label>
				<select class="form-control" id="ruolo" name="ruolo">
					<option value="1">Admin</option>
					<option value="4">Utente</option>
				</select>
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input type="password" class="form-control" id="password" name="password" value="" placeholder="Opzionale. Lasciare vuoto se non si intende cambiare password.">
                </div>
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<button type="submit" class="btn btn-default">Salva Modifiche</button>
	</form>
</div>
</body>
</html>


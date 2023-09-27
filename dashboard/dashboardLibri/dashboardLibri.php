<?php
session_start();
require_once("../../autenticazione/cookies.php");
if ($_SESSION['utenza'] == 1 || $_SESSION['utenza'] == 2) {

} else {
	header("Location: ../../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="viewport" content="width=device-width, user-scalable=no,
	initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
	<title>Dashboard Libri</title>
	<!-- Collegamento ai file CSS di Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="../dashboardUtenti/style.css">
	<link rel="stylesheet" href="../../nav/nav.css">
	<link rel="stylesheet" href="../../things/colors.css">
	<link rel="stylesheet" href="../../things/popup.css">
	<link rel="shortcut icon" href="../../immagini/bookDashFavicon.png" type="image/x-icon">
	<script src="https://code.jquery.com/jquery-1.12.2.js"></script>
</head>

<body>
	<div id="nav-placeholder"></div>
	<script>
		$(function () {
			$("#nav-placeholder").load("../../nav/nav.php");
		});
	</script>

	<div class="container-fluid">
		<h1 class="text-center" style="font-size:4rem !important;">&#128218;</h1>
		<br>
		<center>
			<!-- INSERT DI LIBRO RANDOM -->
	
			<form action="dashboardLibri.php" method='POST'>
				<button class='btn btn-secondary' type='submit' name='createDummy'>CREA LIBRO RANDOM</button>
			</form>
			<?php
			if (isset($_POST['createDummy'])) {
				$isbnDummy = rand(1000000000000,9999999999999);
				$sql = "INSERT INTO Opera (`ISBN`, `Nome`, `Autore`, `Genere`, `Descrizione`, `Copertina`, `CasaEditrice`, `AnnoPubblicazione`)
					VALUES ($isbnDummy, 'Dummy', 'Dummy', 'Umoristico', 'DummyDummyDummy', 'things/default.png', 'Dummy', 1984)";

				$sql2 = "INSERT INTO copiaLibro (`ISBN`, `Stato`) VALUES ($isbnDummy, '1')";

				if ($conn->query($sql) === TRUE) {
					$conn->query($sql2);
					
					$_SESSION['success_msg'] = "Dummy aggiunto al database";
					header("Location: dashboardLibri.php");
					exit(); 
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			}
			?>

			<?php
			if (isset($_SESSION['success_msg'])) {
				echo '<br><h5 style="color: green"><strong>' . $_SESSION["success_msg"] . '</strong></h5>';
				unset($_SESSION['success_msg']);
			} else if (isset($_SESSION['error_msg'])) {
				echo '<br><h5 style="color: red"><strong>' . $_SESSION["error_msg"] . '</strong></h5>';
				unset($_SESSION['error_msg']);
			}
			?>
		</center>

		<form class="form-inline mx-auto" style="width: 300px;" action="dashboardLibri.php" method="post">
			<input class="form-control mr-sm-2 searchbar" type="search" name="search" placeholder="Ricerca un libro..."
				aria-label="Cerca">
			<input class="btn btn-outline-info my-2 my-sm-0" name="search_btn" type="submit" value="Cerca">
		</form>
		<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead class="thead-dark">
				<form action="dashboardLibri.php" method="post">
					<tr>
						<th scope="col" name="test">ISBN<button class="sort_btn" name="sort_isbn">&ensp;
								&#x25B2;</button></th>
						<th scope="col">Titolo<button class="sort_btn" name="sort_nome">&ensp; &#x25B2;</button></th>
						<th scope="col">Autore<button class="sort_btn" name="sort_autore">&ensp; &#x25B2;</button></th>
						<th scope="col">Genere<button class="sort_btn" name="sort_genere">&ensp; &#x25B2;</button></th>
						<th scope="col">Anno<button class="sort_btn" name="sort_anno">&ensp; &#x25B2;</button></th>
						<th scope="col">Casa Editrice<button class="sort_btn" name="sort_casaeditrice">&ensp;
								&#x25B2;</button></th>
						<th scope="col">Azioni <div class="btn_adduser"><a href="aggiungiLibro.php"
									class="btn btn-success ml-auto">Aggiungi libro</a></div>
						</th>
					</tr>
				</form>
			</thead>
			<tbody>
				<?php
				require_once("../../things/Connect.php");
				$table = "Opera";

				switch (true) {
					case isset($_POST['search_btn']):
						$search_text = $_POST['search'];
						try {
							foreach ($conn->query("SELECT ISBN, Nome, Autore, Genere, AnnoPubblicazione, CasaEditrice FROM $table WHERE Nome LIKE '%$search_text%' OR Autore LIKE '%$search_text%' OR Genere LIKE '%$search_text%' OR AnnoPubblicazione LIKE '%$search_text%' OR CasaEditrice LIKE '%$search_text%' OR ISBN LIKE '%$search_text%'") as $row) {
								printLibri($row);
							}
							$conn->close();
						} catch (PDOException $e) {
							print "Error!: " . $e->getMessage() . "<br/>";
							die();
						}
						break;

					case isset($_POST['sort_isbn']):
						try {
							foreach ($conn->query("SELECT ISBN, Nome, Autore, Genere, AnnoPubblicazione, CasaEditrice FROM $table ORDER BY ISBN") as $row) {
								printLibri($row);
							}
							$conn->close();
						} catch (PDOException $e) {
							print "Error!: " . $e->getMessage() . "<br/>";
							die();
						}
						break;

					case isset($_POST['sort_nome']):
						try {
							foreach ($conn->query("SELECT ISBN, Nome, Autore, Genere, AnnoPubblicazione, CasaEditrice FROM $table ORDER BY Nome") as $row) {
								printLibri($row);
							}
							$conn->close();
						} catch (PDOException $e) {
							print "Error!: " . $e->getMessage() . "<br/>";
							die();
						}
						break;

					case isset($_POST['sort_autore']):
						try {
							foreach ($conn->query("SELECT ISBN, Nome, Autore, Genere, AnnoPubblicazione, CasaEditrice FROM $table ORDER BY Autore") as $row) {
								printLibri($row);
								$conn->close();
							}
						} catch (PDOException $e) {
							print "Error!: " . $e->getMessage() . "<br/>";
							die();
						}
						break;

					case isset($_POST['sort_genere']):
						try {
							foreach ($conn->query("SELECT ISBN, Nome, Autore, Genere, AnnoPubblicazione, CasaEditrice FROM $table ORDER BY Genere") as $row) {
								printLibri($row);
								$conn->close();
							}
						} catch (PDOException $e) {
							print "Error!: " . $e->getMessage() . "<br/>";
							die();
						}
						break;

					case isset($_POST['sort_anno']):
						try {
							foreach ($conn->query("SELECT ISBN, Nome, Autore, Genere, AnnoPubblicazione, CasaEditrice FROM $table ORDER BY AnnoPubblicazione") as $row) {
								printLibri($row);
								$conn->close();
							}
						} catch (PDOException $e) {
							print "Error!: " . $e->getMessage() . "<br/>";
							die();
						}
						break;

					case isset($_POST['sort_casaeditrice']):
						try {
							foreach ($conn->query("SELECT ISBN, Nome, Autore, Genere, AnnoPubblicazione, CasaEditrice FROM $table ORDER BY CasaEditrice") as $row) {
								printLibri($row);
								$conn->close();
							}
						} catch (PDOException $e) {
							print "Error!: " . $e->getMessage() . "<br/>";
							die();
						}
						break;

					default:
						try {
							foreach ($conn->query("SELECT ISBN, Nome, Autore, Genere, AnnoPubblicazione, CasaEditrice FROM $table") as $row) {
								printLibri($row);
								$conn->close();
							}
						} catch (PDOException $e) {
							print "Error!: " . $e->getMessage() . "<br/>";
							die();
						}
						break;
				}

				function printLibri(&$row)
				{
					echo "<tr>
						<th scope='row'>" . $row['ISBN'] . "</th>
						<td>" . $row['Nome'] . "</td>
						<td>" . $row['Autore'] . "</td>
						<td>" . $row['Genere'] . "</td>
						<td>" . $row['AnnoPubblicazione'] . "</td>
						<td>" . $row['CasaEditrice'] . "</td>
						<td>
							<a class='btn btn-primary' href='modificaLibro.php?id=" . $row['ISBN'] . "'>Modifica</a>
							<a class='btn btn-danger' href='eliminaLibro.php?id=" . $row['ISBN'] . "'>Elimina</a>
						</td>
						</tr>";
				}
				?>
			</tbody>
		</table>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
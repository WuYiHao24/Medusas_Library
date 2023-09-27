<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Segnalazioni</title>
    <!-- <link rel="stylesheet" href="../../nav/nav.css">
	  <link rel="stylesheet" href="../../things/colors.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../immagini/segnDashFavicon.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-1.12.2.js"></script>
</head>
<body>
<!-- <div id="nav-placeholder"></div>
	<script>
		$(function () {
			$("#nav-placeholder").load("../../nav/nav.php");
		});
	</script> -->
<div class="container mt-5">
  <div class="row">
    <div class="col-md-12">
      <h2>Segnalazioni Utenti</h2>
      <hr>
    </div>
  </div>
 
  <div class="row">
  
  <?php
        require_once("../../things/Connect.php");

        try {
            foreach($conn->query("SELECT idSegnalazione, userEmail, Oggetto FROM Segnalazione") as $row) {
            //echo($row['idSegnalazione'] . $row['userEmail'] . $row['Oggetto']);
           
            echo ("<div class='col-md-6'>
                     <div class='card mb-3'>
                        <div class='card-body'>
                            <h5 class='card-title'>Segnalazione n°" . $row['idSegnalazione'] . "</h5>
                            <h6 class='card-subtitle mb-2 text-muted'>" . $row['userEmail'] . "</h6>
                            <p class='card-text'>" . $row['Oggetto'] . "</p>
                            <a href='dettaglio.php?id=".$row['idSegnalazione']."' class='card-link'>Dettagli</a>
                        </div>
                    </div>
                </div>");
        }
        } catch (PDOException $e) {
            //throw $th;
        }
        
    ?>
</div>

<!-- 

  <div class="row">
    <div class="col-md-6">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">Segnalazione n°" . $row['idSegnalazione'] . "</h5>
          <h6 class="card-subtitle mb-2 text-muted">" . $row['userEmail'] . "</h6>
          <p class="card-text">" . $row['Oggetto'] . "</p>
          <a href="#" class="card-link">Dettagli</a>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">Segnalazione 456</h5>
          <h6 class="card-subtitle mb-2 text-muted">Oggetto della segnalazione</h6>
          <p class="card-text">Breve descrizione della segnalazione.</p>
          <a href="dettagli.html" class="card-link">Dettagli</a>
        </div>
      </div>
    </div>
  </div> -->


</body>
</html>
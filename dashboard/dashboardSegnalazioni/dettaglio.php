<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dettaglio Segnalazioni</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
  
<div class="container mt-5">

<?php
  $idSegnalazione = $_GET['id'];
  
  require_once("../../things/Connect.php");

  $sql = "SELECT userEmail, Oggetto, Messaggio, imgSegn FROM Segnalazione WHERE idSegnalazione = $idSegnalazione";

  try {
    foreach($conn->query($sql) as $row) {
      
      if (!empty($row['imgSegn'])) {
        echo "<center>
                <div class='row'>
                  <div class='col-md-12'>
                    <h2>Dettagli Segnalazione n°".$idSegnalazione."</h2>
                    <h5>Utente: ".$row['userEmail']."</h5>
                    <hr>
                  </div>
                </div>
              </center>
    
              <div class='row justify-content-center'>
                <div class='col-md-5'>
                  <div class='card'>
                    <div class='card-body'>
                      <h5 class='card-title'>".$row['Oggetto']."</h5>
                      <p class='card-text'>".$row['Messaggio']."</p>
                    </div>
                    <img src='../../segnalazione/".$row['imgSegn']."' class='card-img-bottom'>
                    <a href='eliminaSegnalazione.php?id=".$idSegnalazione."' class='btn btn-danger mt-2'><i class='fa fa-trash'></i> Elimina Segnalazione</a>
                  </div>
                </div>
              </div>
            </div>"; 
      } else {
        echo "<center>
                <div class='row'>
                  <div class='col-md-12'>
                    <h2>Dettagli Segnalazione n°".$idSegnalazione."</h2>
                    <h5>Utente: ".$row['userEmail']."</h5>
                    <hr>
                  </div>
                </div>
              </center>
    
              <div class='row justify-content-center'>
                <div class='col-md-5'>
                  <div class='card'>
                    <div class='card-body'>
                      <h5 class='card-title'>".$row['Oggetto']."</h5>
                      <p class='card-text'>".$row['Messaggio']."</p>
                    </div>
                    <a href='eliminaSegnalazione.php?id=".$idSegnalazione."' class='btn btn-danger mt-2'><i class='fa fa-trash'></i> Elimina Segnalazione</a>
                  </div>
                </div>
              </div>
            </div>";
      }
    }      
  } catch (PDOException $e) {
    //throw $th;
  }
?>

</body>
</html>

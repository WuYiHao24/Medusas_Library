<!DOCTYPE html>
  <html lang="en">
    
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="../things/colors.css">
    <link rel="stylesheet" href="../nav/nav.css">
    <link rel="shortcut icon" href="../immagini/dashFavicon.png" type="image/x-icon">
        <!--script per importare parti di codice-->
        <script src="https://code.jquery.com/jquery-1.12.2.js"></script>
  </head>

  <body>

  <div id="nav-placeholder"></div>
    <script>
      $(function () {
        $("#nav-placeholder").load("../nav/nav.php");
      });
    </script>

    <div class="container">
        <a href="dashboardUtenti/dashboardUtenti.php">
          <div class="card-container">
            <img src="../immagini/account-circle-icon.png" alt="">
            <h4>Dashboard Utenti</h4>
          </div>
        </a>
        <a href="dashboardLibri/dashboardLibri.php">
          <div class="card-container">
            <img src="../immagini/list.png" alt="">
            <h4>Dashboard Libri</h4>
          </div>
        </a>
        <a href="dashboardSegnalazioni/dashboardSegnalazioni.php">
          <div class="card-container">
            <img src="../immagini/warning-icon.png" alt="">
            <h4>Dashboard Segnalazioni</h4>
          </div>
        </a>

    </div>
  </body>
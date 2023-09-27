<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, user-scalable=no,
    initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
  <title>Medusa's Library </title>
  <link rel="stylesheet" href="lista.css">
  <link rel="stylesheet" href="../nav/nav.css">
  <link rel="stylesheet" href="../things/colors.css">
  <link rel="stylesheet" href="hover.css">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">
  <!--script per importare parti di codice-->
  <script src="https://code.jquery.com/jquery-1.12.2.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <div class="safe-area spaced-column">

    <div id="nav-placeholder"></div>
    <script>
      $(function () {
        $("#nav-placeholder").load("../nav/nav.php");
      });
    </script>

    <!--sb-->

    <div class="container" data-user-book-container>

      <h6 class="home-list">‎</h6>

      <div class="main-container">
        <!-- ricerca avanzata -->
        <div class="left-column">
          <div class="sort-by" id="sort-by">
            <img src="../immagini/arrow.png" alt="" width="14px" height="14px">
            <h5>Filtra </h5>
          </div>
          <div class="left-container" id="left-container">
            <a href="lista.php"><img style="margin: 3.5px, 3.5px, 0px, 5px;" src="../immagini/title.png" alt=""
                class="icon1">
              <h5 class="titolo">Titolo</h5>
            </a>
            <form action="#" class="genere" id="genere"><img src="../immagini/genere.png" alt="" class="icon1">
              <h5>Genere</h5> <img src="../immagini/down-arrow.png" width="14px" height="14px" alt="">
            </form>
            <div class="genere-subwrap" id="genere-subwrap">
              <form action="lista.php" method="post">
                <button class="genere" name="r-storico">Romanzo Storico</button>
                  <button class="genere" name="giallo">Giallo</button>
                  <button class="genere" name="biografia">Biografia</button>
                  <button class="genere" name="avventura">Avventura</button>
                  <button class="genere" name="azione">Azione</button>
                  <button class="genere" name="fantascienza">Fantascienza</button>
                  <button class="genere" name="horror">Horror</button>
                  <button class="genere" name="umoristico">Umoristico</button>
                  <button class="genere" name="distopia">Distopia</button>
              </form>
            </div>
            <form action="#"><img src="../immagini/calendar.png" alt="" class="icon1">
              <button class="genere" name="anno"><h5>Anno</h5></button>
            </form>
            <!-- <form action="#"><img src="../immagini/relevance.png" alt="" class="icon1">
              <h5>Rilevanza</h5>
            </form> -->
            
          </div>

        </div>

        <div class="right-column">
          <?php
          require_once("../things/Connect.php");
          $table = "Opera";
          $maxPerPage = 10;

          function paginator($where)
          {
            global $conn;
            global $table;
            global $maxPerPage;
            global $paginationCtrls;
            $pageTo = "lista.php";
            $limit = "";

            $result = mysqli_query($conn, "SELECT count(*) as tot FROM $table $where");
            $row = $result->fetch_assoc();
            $rowCount = $row['tot'];

            if ($rowCount > 0) {
              $p = $_GET['page'];
              $page = isset($p) ? preg_replace('#[^0-9]#', '', $p) : 1;
              $lastPage = ceil($rowCount / $maxPerPage);

              if ($page < 1) {
                $page = 1;
              } elseif ($page > $lastPage) {
                $page = $lastPage;
              }

              $limit = 'LIMIT ' . $maxPerPage . ' OFFSET ' . ($page - 1) * $maxPerPage;

              //page controls
          
              $paginationCtrls = '';
              // Show the pagination if the rows numbers is worth displaying 
              if ($lastPage != 1) {
                /*
                First we check if we are on page one. If yes then we don't need a link to 
                the previous page or the first page so we do nothing. If we aren't then we
                generate links to the first page, and to the previous pages.
                */
                if ($page > 1) {
                  $previous = $page - 1;
                  // Concatenate the link to the variable
                  $paginationCtrls .= '
                      <a href="' . $pageTo . '?page=' . $previous . '">
                      &laquo;
                      </a>
                      ';
                  // Render clickable number links that should appear on the left of the target (current) page number
                  for ($i = $page - 4; $i < $page; $i++) {
                    if ($i > 0) {
                      // Concatenate the link to the variable
                      $paginationCtrls .= '
                          <a href="' . $pageTo . '?page=' . $i . '">
                              ' . $i . '
                          </a>
                          ';
                    }
                  }
                }
                // Render the target (current) page number, but without it being a clickable link
                // Concatenate the link to the variable
                $paginationCtrls .= '
                    <a class="active">
                        ' . $page . '
                    </a>
                    ';
                // Render clickable number links that should appear on the right of the target (current) page number
                for ($i = $page + 1; $i <= $lastPage; $i++) {
                  // Concatenate the link to the variable
                  $paginationCtrls .= '
                      <a href="' . $pageTo . '?page=' . $i . '">
                          ' . $i . '
                      </a>
                      ';
                  // if the loop runs for tims then break (stop) it.
                  if ($i >= $page + 4) {
                    break;
                  }
                }
                // This does the same as above, only checking if we are on the last page, if not then generating the "Next"
                if ($page != $lastPage) {
                  $next = $page + 1;
                  // Concatenate the link to the variable
                  $paginationCtrls .= '
                      <a href="' . $pageTo . '?page=' . $next . '">
                      &raquo;  
                      </a>
                      ';
                }
              }

              //
            }

            return $limit;
          }

          // Search PHP
          if (isset($_POST["search_btn"])) {
            try {
              $search_text = $_POST["search"];

              $result = $conn->query("SELECT id, Nome, Autore, CasaEditrice, Descrizione, Copertina, ISBN, Genere FROM $table WHERE 
              Nome LIKE '%$search_text%' OR 
              Autore LIKE '%$search_text%' OR 
              ISBN LIKE '%$search_text%' OR 
              CasaEditrice LIKE '%$search_text%'");

              if (mysqli_num_rows($result) > 0) {

                $limit = paginator("WHERE 
                Nome LIKE '%$search_text%' OR 
                Autore LIKE '%$search_text%' OR 
                ISBN LIKE '%$search_text%' OR 
                CasaEditrice LIKE '%$search_text%'");

                foreach ($conn->query("SELECT id, Nome, Autore, CasaEditrice, Descrizione, Copertina, ISBN, Genere FROM $table WHERE 
                Nome LIKE '%$search_text%' OR 
                Autore LIKE '%$search_text%' OR 
                ISBN LIKE '%$search_text%' OR 
                CasaEditrice LIKE '%$search_text%' $limit") as $row) {

                  $id = $row['id'];
                  $disp = "SELECT count(idCopia) as qty FROM copiaLibro, Opera WHERE Stato = 1 and id = $id and Opera.ISBN = copiaLibro.ISBN";
                  $result_disp = mysqli_query($conn, $disp);
                  $qty = mysqli_fetch_assoc($result_disp);

                  if ($qty['qty'] >= 1) {
                    $disponibilita = "Disponibile";
                    $color = "green";
                  } else {
                    $disponibilita = "Non disponibile";
                    $color = "red";
                  }

                  echo "
                    <a href='../libro/libro.php?id=" . $row['id'] . "'>
                      <div class='book-list hvr-float data-single-book'>
                        <img src='../" . $row['Copertina'] . "' width='113' height='171' class='book-img'>
                        <div class='container-book'>
                          <a href='../libro/libro.php?id=" . $row['id'] . "' class='book-link trunctitle'><span class='trunctitle' data-title>" . $row['Nome'] . "</span></a>
                          <p class='book-authors' data-authors>" . $row['Autore'] . " | " . $row['CasaEditrice'] . " | " . $row['ISBN'] . " | " . $row['Genere'] . "</p>
                          <p class='desc'>" . $row['Descrizione'] . "</p>
                          <span style='color: $color; ' class='disponibilita'>" . $disponibilita . "</span>
                        </div>
                      </div>
                    </a>";
                }
              } else {
                echo "<h4>Nessun libro trovato.</h4>";
              }
            } catch (PDOException $e) {
              print "Error!: " . $e->getMessage() . "<br/>";
              die();
            }

          } else {
            try {

              switch (true) {
                case isset($_POST['r-storico']):
                  $limit = paginator("WHERE Genere = 'Romanzo Storico'");
                  $query = "SELECT id, Nome, Autore, Descrizione, Copertina, CasaEditrice, ISBN, Genere FROM $table WHERE Genere = 'Romanzo Storico'";
                  $gen = "Romanzo Storico";
                  $ordina = 1;
                  break;
                case isset($_POST['giallo']):
                  $limit = paginator("WHERE Genere = 'Giallo'");
                  $query = "SELECT id, Nome, Autore, Descrizione, Copertina, CasaEditrice, ISBN, Genere FROM $table WHERE Genere = 'Giallo'";
                  $gen = "Giallo";
                  $ordina = 1;
                  break;
                case isset($_POST['biografia']):
                  $limit = paginator("WHERE Genere = 'Biografia'");
                  $query = "SELECT id, Nome, Autore, Descrizione, Copertina, CasaEditrice, ISBN, Genere FROM $table WHERE Genere = 'Biografia'";
                  $gen = "Biografia";
                  $ordina = 1;
                  break;
                case isset($_POST['avventura']):
                  $limit = paginator("WHERE Genere = 'Avventura'");
                  $query = "SELECT id, Nome, Autore, Descrizione, Copertina, CasaEditrice, ISBN, Genere FROM $table WHERE Genere = 'Avventura'";
                  $gen = "Avventura";
                  $ordina = 1;
                  break;
                case isset($_POST['azione']):
                  $limit = paginator("WHERE Genere = 'Azione'");
                  $query = "SELECT id, Nome, Autore, Descrizione, Copertina, CasaEditrice, ISBN, Genere FROM $table WHERE Genere = 'Azione'";
                  $gen = "Azione";
                  $ordina = 1;
                  break;
                case isset($_POST['fantascienza']):
                  $limit = paginator("WHERE Genere = 'Fantascienza'");
                  $query = "SELECT id, Nome, Autore, Descrizione, Copertina, CasaEditrice, ISBN, Genere FROM $table WHERE Genere = 'Fantascienza'";
                  $gen = "Fantascienza";
                  $ordina = 1;
                  break;
                case isset($_POST['horror']):
                  $limit = paginator("WHERE Genere = 'Horror'");
                  $query = "SELECT id, Nome, Autore, Descrizione, Copertina, CasaEditrice, ISBN, Genere FROM $table WHERE Genere = 'Horror'";
                  $gen = "Horror";
                  $ordina = 1;
                  break;
                case isset($_POST['umoristico']):
                  $limit = paginator("WHERE Genere = 'Umoristico'");
                  $query = "SELECT id, Nome, Autore, Descrizione, Copertina, CasaEditrice, ISBN, Genere FROM $table WHERE Genere = 'Umoristico'";
                  $gen = "Umoristico";
                  $ordina = 1;
                  break;
                case isset($_POST['distopia']):
                  $limit = paginator("WHERE Genere = 'Distopia'");
                  $query = "SELECT id, Nome, Autore, Descrizione, Copertina, CasaEditrice, ISBN, Genere FROM $table WHERE Genere = 'Distopia'";
                  $gen = "Distopia";
                  $ordina = 1;
                  break;
                // case isset($_POST['anno']):
                //   $limit = paginator("ORDER BY AnnoPubblicazione");
                //   $query = "SELECT id, Nome, Autore, Descrizione, Copertina, CasaEditrice, ISBN, Genere FROM $table ORDER BY AnnoPubblicazione";
                //   $ordina = 0;
                //   break;
                default:
                  $limit = paginator("ORDER BY Nome");
                  $query = "SELECT id, Nome, Autore, Descrizione, Copertina, CasaEditrice, ISBN, Genere FROM $table ORDER BY Nome";
                  $ordina = 0;
                  break;
              }
              foreach ($conn->query("$query $limit") as $row) {
                $id = $row['id'];
                $disp = "SELECT count(idCopia) as qty FROM copiaLibro, Opera WHERE Stato = 1 and id = $id and Opera.ISBN = copiaLibro.ISBN";
                $result_disp = mysqli_query($conn, $disp);
                $qty = mysqli_fetch_assoc($result_disp);

                if ($qty['qty'] >= 1) {
                  $disponibilita = "Disponibile";
                  $color = "green";
                } else {
                  $disponibilita = "Non disponibile";
                  $color = "red";
                }
                /*
                if ($ordina == 1) {
                $back_col = "#eadcff";
                } else {
                $back_col = "#ffffff";
                }
                */
                echo "
                  <a href='../libro/libro.php?id=" . $row['id'] . "' style='display: block;'>
                    <div class='book-list hvr-float data-single-book' style='background-color: " . $back_col . " !important;'>
                      <img src='../" . $row['Copertina'] . "' width='113' height='171' class='book-img'>
                      <div class='container-book'>
                        <a href='../libro/libro.php?id=" . $row['id'] . "' class='book-link trunctitle'><span class='trunctitle' data-title>" . $row['Nome'] . "</span></a>
                        <p class='book-authors' data-authors>" . $row['Autore'] . " | " . $row['CasaEditrice'] . " | " . $row['ISBN'] . " | " . $row['Genere'] . "</p>
                        <p class='desc'>" . $row['Descrizione'] . "</p>
                        <span style='color: $color; ' class='disponibilita'>" . $disponibilita . "</span>
                      </div>
                    </div>
                  </a>";
              }

              /*
              if ($ordina == 1) {
              foreach ($conn->query("SELECT id, Nome, Autore, Descrizione, Copertina, CasaEditrice, ISBN FROM $table WHERE Genere NOT IN (SELECT Genere FROM $table WHERE Genere = '$gen')") as $row) {
              $id = $row['id'];
              $disp = "SELECT count(idCopia) as qty FROM copiaLibro, Opera WHERE Stato = 1 and id = $id and Opera.ISBN = copiaLibro.ISBN";
              $result_disp = mysqli_query($conn, $disp);
              $qty = mysqli_fetch_assoc($result_disp);
              if ($qty['qty'] >= 1) {
              $disponibilita = "Disponibile";
              $color = "green";
              } else {
              $disponibilita = "Non disponibile";
              $color = "red";
              }
              echo "
              <a href='../libro/libro.php?id=" . $row['id'] . "' style='display: block;'>
              <div class='book-list hvr-float data-single-book'>
              <img src='../" . $row['Copertina'] . "' width='113' height='171' class='book-img'>
              <div class='container-book'>
              <a href='../libro/libro.php?id=" . $row['id'] . "' class='book-link trunctitle'><span class='trunctitle' data-title>" . $row['Nome'] . "</span></a>
              <p class='book-authors' data-authors>" . $row['Autore'] . " | " . $row['CasaEditrice'] . " | " . $row['ISBN'] . " | " . $row['Genere'] . "</p>
              <p class='desc'>" . $row['Descrizione'] . "</p>
              <span style='color: $color; ' class='disponibilita'>" . $disponibilita . "</span>
              </div>
              </div>
              </a>";
              }
              }
              */

            } catch (PDOException $e) {
              print "Error!: " . $e->getMessage() . "<br/>";
              die();
            }
          }

          echo '<div class="center">
                  <div class="pagination">' .
            $paginationCtrls .
            '</div>
                </div>';
          ?>
        </div>

      </div>
    </div>
  </div>

</body>



<script>
  $(document).ready(function () {
    $("#sort-by").click(function () {
      $("#left-container").toggle();
    });
  }); 
</script>

<script>
  $(document).ready(function () {
    $("#genere").click(function () {
      $("#genere-subwrap").slideToggle();
    });
  }); 
</script>
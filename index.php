<?php

session_start();

require_once("autenticazione/cookies.php");


if (isset($_SESSION['email'])) {

    $email = $_SESSION['email'];

}

?>


<!DOCTYPE html>

<html lang="en">


<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="things/homepage.css">

    <link rel="stylesheet" href="lista/hover.css">

    <link rel="stylesheet" href="nav/nav.css">

    <script src="https://code.jquery.com/jquery-1.12.2.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>HomePage - Medusa </title>

</head>


<body>


    <script src="things/homepage.js"></script>


    <nav id="nav-placeholder"></nav>

    <script>

        $(function () {

            $("#nav-placeholder").load("nav/nav.php");

        }); 

    </script>


    <div class="main-container">

        <div class="book-slider">

            <h2 class="titolo-ultime-aggiunte">Ultime aggiunte</h2>

            <section class="section slider ">


                <div class="section__entry section__entry--center">

                </div>


                <input type="radio" name="slider" id="slide-1" class="slider__radio">

                <input type="radio" name="slider" id="slide-2" class="slider__radio" checked>

                <input type="radio" name="slider" id="slide-3" class="slider__radio">


                <div class="slider__holder">


                    <label for="slide-1" class="slider__item slider__item--1 card">


                        <?php

                        require_once("things/Connect.php");


                        $table = "Opera";

                        $query = "SELECT id, Nome, Autore, Copertina, CasaEditrice, ISBN, AnnoPubblicazione, Descrizione FROM $table WHERE id = (SELECT MAX(id) FROM Opera)";

                        $result = mysqli_query($conn, $query);

                        $row = mysqli_fetch_assoc($result);

                        $idLibro = $row['id'];


                        echo "   

                                

                                <div class='slider__item-content'>

                                <div class='left-column'>

                                <a href='libro/libro.php?id=" . $row['id'] . "'>

                                    <img src='" . $row['Copertina'] . "' alt='' class='cover'>

                                    </a>

                                </div>

                                <a href='libro/libro.php?id=" . $row['id'] . "'>

                                <div class='right-column'>

                                    <h3>" . $row['Nome'] . "</h3>

                                    <div class='info-release'>

                                        <span>" . $row['Autore'] . "</span>

                                        <span>" . $row['CasaEditrice'] . "</span>

                                        <span>" . $row['AnnoPubblicazione'] . "</span>

                                        <span>" . $row['ISBN'] . "</span>

                                        <span>" . $row['Genere'] . "</span>

                                    </div>

                                    <p class='desc'>

                                    " . $row['Descrizione'] . "

                                    </p>

                                </div>

                                </a>

                            ";



                        ?>



                </div>


                </label> <!-- Slider__item -->


                <label for="slide-2" class="slider__item slider__item--2 card ">


                    <?php


                    $query = "SELECT id, Nome, Autore, Copertina, CasaEditrice, ISBN, AnnoPubblicazione, Descrizione FROM $table WHERE id = (SELECT MAX(id) FROM Opera WHERE id < $idLibro)";

                    $result = mysqli_query($conn, $query);

                    $row = mysqli_fetch_assoc($result);

                    $idLibro = $row['id'];


                    echo "

                            <div class='slider__item-content'>

                            <div class='left-column'>

                            <a href='libro/libro.php?id=" . $row['id'] . "'>

                                <img src='" . $row['Copertina'] . "' alt='' class='cover'>

                                </a>

                            </div>

                            <a href='libro/libro.php?id=" . $row['id'] . "'>

                            <div class='right-column'>

                                <h3>" . $row['Nome'] . "</h3>

                                <div class='info-release'>

                                    <span>" . $row['Autore'] . "</span>

                                    <span>" . $row['CasaEditrice'] . "</span>

                                    <span>" . $row['AnnoPubblicazione'] . "</span>

                                    <span>" . $row['ISBN'] . "</span>

                                    <span>" . $row['Genere'] . "</span>

                                </div>

                                <p class='desc'>

                                " . $row['Descrizione'] . "

                                </p>

                            </div>

                            </a>

                            ";

                    ?>

        </div>

        </label> <!-- Slider__item -->


        <label for="slide-3" class="slider__item slider__item--3 card">


            <?php


            $query = "SELECT id, Nome, Autore, Copertina, CasaEditrice, ISBN, AnnoPubblicazione, Descrizione FROM $table WHERE id = (SELECT MAX(id) FROM Opera WHERE id < $idLibro)";

            $result = mysqli_query($conn, $query);

            $row = mysqli_fetch_assoc($result);

            $idLibro = $row['id'];


            echo "

                            <div class='slider__item-content'>

                            <div class='left-column'>

                            <a href='libro/libro.php?id=" . $row['id'] . "'>

                                <img src='" . $row['Copertina'] . "' alt='' class='cover'>

                                </a>

                            </div>

                            <a href='libro/libro.php?id=" . $row['id'] . "'>

                            <div class='right-column'>

                                <h3>" . $row['Nome'] . "</h3>

                                <div class='info-release'>

                                    <span>" . $row['Autore'] . "</span>

                                    <span>" . $row['CasaEditrice'] . "</span>

                                    <span>" . $row['AnnoPubblicazione'] . "</span>

                                    <span>" . $row['ISBN'] . "</span>

                                    <span>" . $row['Genere'] . "</span>

                                </div>

                                <p class='desc'>

                                " . $row['Descrizione'] . "

                                </p>

                            </div>

                            </a>

                            ";

            ?>

    </div>

    </label> <!-- Slider__item -->



    </div> <!-- Slider Holder -->




    </section> <!-- Section Slider -->



    </div>




    <?php


    //ultime prenotazioni

    if (isset($_SESSION['utenza'])) {

        $utenza = $_SESSION['utenza'];

    }


    if (isset($_SESSION['utenza'])) {


        $class = "account-status-2";

        $href = "href='editprofile/Edit_Profile.php'";

    } else {

        $class = "account-status-2 blur";

        $href = "href='autenticazione/Login.php'";

    }


    if (isset($_SESSION['utenza']) && $utenza != 1 && $utenza != 2) {

        //1

        $query2 = "SELECT Nome, Autore, Copertina, Prenotazione.Stato as Stato, idPrenotazione, Inizio, Fine 

                    FROM Prenotazione, Opera, copiaLibro 

                    WHERE copiaLibro.idCopia = Prenotazione.idCopia 

                    AND copiaLibro.ISBN = Opera.ISBN 

                    AND idPrenotazione = (SELECT MAX(idPrenotazione) FROM Prenotazione  WHERE Stato <> 5 AND Email = '$email')";


        $result2 = mysqli_query($conn, $query2);

        $count = $result2->num_rows;


        $prenotazione = mysqli_fetch_assoc($result2);

        $idPrenotazione = $prenotazione['idPrenotazione'];


        if ($prenotazione['Stato'] == 0) {

            $stato = "Prenotato";

            $color = "#ff7600";

        } else if ($prenotazione['Stato'] == 1) {

            $stato = "In Prestito";

            $color = "green";

        } else if ($prenotazione['Stato'] == 2) {

            $stato = "In ritardo";

            $color = "red";

        } else if ($prenotazione['Stato'] == 3) {

            $stato = "Riconsegnare";

            $color = "#ff7600";

        } else if ($prenotazione['Stato'] == 4) {

            $stato = "Riconsegnato";

            $color = "#686868";

        }


        $class = "account-status";

        $href = "href='editprofile/Edit_Profile.php'";


        if ($count != 0) {

            echo "

                <div class='info-account'>

                <a href='prenotazione/prenotazione.php'>

                    <div class='info-prenotazioni'>

                    <h2 class='ultime-prenotazioni'>Ultime Prenotazioni</h2>

                        <div class='book-prenotation'>

                            <img src='" . $prenotazione['Copertina'] . "' alt='' class='cover'>

                            <div class='book-right-column'>

                                <h4>" . $prenotazione['Nome'] . "</h4>

                                <span>" . $prenotazione['Autore'] . "</span>

                                <span style='font-weight: bold; margin-top: 9px; color: $color'>" . $stato . "</span>

                                <div class='inizio-fine'>

                                    <span>Inizio Prenotazione</span>

                                    <span>" . $prenotazione['Inizio'] . "</span>

                                </div>

                                <div class='inizio-fine'>

                                    <span>Fine Prenotazione</span>

                                    <span>" . $prenotazione['Fine'] . "</span>

                                </div>

                            </div>

                        </div>";


            //2

            $query2 = "SELECT Nome, Autore, Copertina, Prenotazione.Stato as Stato, idPrenotazione, Inizio, Fine 

                            FROM Prenotazione, Opera, copiaLibro 

                            WHERE copiaLibro.idCopia = Prenotazione.idCopia 

                            AND copiaLibro.ISBN = Opera.ISBN 

                            AND idPrenotazione = (SELECT MAX(idPrenotazione) FROM Prenotazione WHERE Stato <> 5 AND idPrenotazione < $idPrenotazione AND Email = '$email')";

            $result2 = mysqli_query($conn, $query2);

            $count = $result2->num_rows;

            if ($count != 0) {

                $prenotazione = mysqli_fetch_assoc($result2);

                $idPrenotazione = $prenotazione2['idPrenotazione'];


                if ($prenotazione['Stato'] == 0) {

                    $stato = "Prenotato";

                    $color = "#ff7600";

                } else if ($prenotazione['Stato'] == 1) {

                    $stato = "In Prestito";

                    $color = "green";

                } else if ($prenotazione['Stato'] == 2) {

                    $stato = "In ritardo";

                    $color = "red";

                } else if ($prenotazione['Stato'] == 3) {

                    $stato = "Riconsegnare";

                    $color = "#ff7600";

                } else if ($prenotazione['Stato'] == 4) {

                    $stato = "Riconsegnato";

                    $color = "#686868";

                }


                echo "

                            <div class='book-prenotation'>

                                <img src='" . $prenotazione['Copertina'] . "' alt='' class='cover'>

                                <div class='book-right-column'>

                                    <h4>" . $prenotazione['Nome'] . "</h4>

                                    <span>" . $prenotazione['Autore'] . "</span>

                                    <span style='font-weight: bold; margin-top: 9px; color: $color'>" . $stato . "</span>

                                    <div class='inizio-fine'>

                                        <span>Inizio Prenotazione</span>

                                        <span>" . $prenotazione['Inizio'] . "</span>

                                    </div>

                                    <div class='inizio-fine'>

                                        <span>Fine Prenotazione</span>

                                        <span>" . $prenotazione['Fine'] . "</span>

                                    </div>

                                    

                                </div>

                                

                            </div>

                        </div>";

            } else {

                echo "</div>";

            }

        } else {

            echo "

                <div class='info-account'>

                    <a href='prenotazione/prenotazione.php'>

                        <div class='info-prenotazioni'>

                            <h2 class='ultime-prenotazioni'>Ultime Prenotazioni</h2>

                                <div class='book-prenotation'>

                                    <div>

                                        <h4>Non hai prenotato nessun libro</h4>

                                    </div>

                                </div>

                              

                            </div>";

        }

    }


    $querys = "SELECT Nome, Cognome, propic FROM Utente WHERE Email = '$email'";

    $results = mysqli_query($conn, $querys);

    $utente = mysqli_fetch_assoc($results);


    if ($utenza != 1 && $utenza != 2) {

        $totali = "SELECT count(idPrenotazione) as totali FROM Prenotazione WHERE Email = '$email' AND Stato <> 5";

        $inCorso = "SELECT count(idPrenotazione) as incorso FROM Prenotazione WHERE Email = '$email' AND Stato <> 4 AND Stato <> 5 AND Stato <> 0";

        $riconsegnate = "SELECT count(idPrenotazione) as riconsegnate FROM Prenotazione WHERE Email = '$email' AND Stato = 4";

    } else {

        $totali = "SELECT count(idPrenotazione) as totali FROM Prenotazione";

        $inCorso = "SELECT count(idPrenotazione) as incorso FROM Prenotazione WHERE Stato <> 4 AND Stato <> 5 AND Stato <> 0";

        $riconsegnate = "SELECT count(idPrenotazione) as riconsegnate FROM Prenotazione WHERE Stato = 4";

    }


    $resultTotali = mysqli_query($conn, $totali);

    $pTotali = mysqli_fetch_assoc($resultTotali);



    $result_inCorso = mysqli_query($conn, $inCorso);

    $p_inCorso = mysqli_fetch_assoc($result_inCorso);



    $result_riconsegnate = mysqli_query($conn, $riconsegnate);

    $p_riconsegnate = mysqli_fetch_assoc($result_riconsegnate);


    echo "

        <a " . $href . ">

            <div class='" . $class . "'>

            <div class='account-status-acc'>

            <span>Bentornato</span>

            <h2>" . $utente['Nome'] . " " . $utente['Cognome'] . "</h2>

            <img src='" . $utente['propic'] . "' alt=''>

            <span>" . $email . "</span>

            <span>---------- Prenotazioni ----------</span>

        </div>

        </a>

        <div class='account-status-prenotazioni'>

            <div class='numero-prenotazioni'>

                <h3>Totali</h3>

                <span>" . $pTotali['totali'] . "</span>

            </div>

            <div class='numero-prenotazioni'>

                <h3>In corso</h3>

                <span>" . $p_inCorso['incorso'] . "</span>

            </div>

            <div class='numero-prenotazioni'>

                <h3>Riconsegnate</h3>

                <span>" . $p_riconsegnate['riconsegnate'] . "</span>

            </div>

        </div>

    </div>";


    ?>



    </div>

    </div>


</body>


</html>

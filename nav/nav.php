<?php
if (isset($_POST['logout'])) {
    setcookie("email", "", time() - 1, '/', 'daniele-carlomusto.bounceme.net'); // delete the cookie 
    setcookie("password", "", time() - 1, '/', 'daniele-carlomusto.bounceme.net'); // delete the cookie 
    session_start();
    session_destroy(); // delete the session 
    header("Location: /MedusaLibrary/progetto5e/index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device.width, initial-scale=1.0">
    <link rel="stylesheet" href="nav.css">
</head>

<body style="background:#ffffff !important;">

    <nav class="nav1">
        <a href="/MedusaLibrary/progetto5e/index.php"><img src="/MedusaLibrary/progetto5e/immagini/logo.png" alt=""
                class="logo"></a>
        <?php
        /*
        require_once("/var/www/html/MedusaLibrary/progetto5e/things/Connect.php");
        session_start();
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            if ($q = $conn->prepare('SELECT * FROM Utente WHERE Email=?')) {
                $q->bind_param('s', $email);
                $q->execute();
                $result = $q->get_result();
                $utente = $result->fetch_assoc();
            }
            if (!($utente['Utenza'] == 1)) {
                echo "<form method='post' action='/MedusaLibrary/progetto5e/lista/lista.php'><input type='search' name='search' placeholder='Search...'><button type='submit' name='search_btn'>Search</button></form>";
            } 
        } else {
            echo "<form method='post' action='/MedusaLibrary/progetto5e/lista/lista.php'><input type='search' name='search' placeholder='Search...'><button type='submit' name='search_btn'>Search</button></form>";
        }
        */
        require_once("/var/www/html/MedusaLibrary/progetto5e/things/Connect.php");
        session_start();
        require_once("../autenticazione/cookies.php");
        echo "<form method='post' action='/MedusaLibrary/progetto5e/lista/lista.php'><input type='search' name='search' placeholder='Search...'><button type='submit' name='search_btn'>Search</button></form>";
        ?>


        <?php


        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            if ($q = $conn->prepare('SELECT * FROM Utente WHERE Email=?')) {
                $q->bind_param('s', $email);
                $q->execute();
                $result = $q->get_result();
                $utente = $result->fetch_assoc();
            }
            
            echo "
            <ul>
            <li class='li-icon'><a href='/MedusaLibrary/progetto5e/lista/lista.php'><img src='/MedusaLibrary/progetto5e/immagini/icona_biblio.svg' class='icon svg' ></a></li>
            <li><img src='/MedusaLibrary/progetto5e/immagini/account-circle-icon.png' alt='' class='icon' onclick='toggleMenu()' ></li>
            
    
            <div class='sub-menu-wrap' id='subMenu'>
                <div class='sub-menu'>
                    <div class='user-info'>
                        <img src='/MedusaLibrary/progetto5e/" . $utente["propic"] . "' alt='' >
                        <h3>" . $utente["Nome"] . " " . $utente["Cognome"] . "</h3>
                        <h4> Punti: ".$utente['punteggio']."</h4>
                    </div>
    
                    <a href='/MedusaLibrary/progetto5e/editprofile/Edit_Profile.php' class='sub-menu-link'>
                        <img src='/MedusaLibrary/progetto5e/immagini/edit-profile.png' alt=''>
                        <p>Edit Profile</p>
                        <span>></span>
                    </a>

                    <a href='/MedusaLibrary/progetto5e/lista/lista.php' class='sub-menu-link'>
                        <img src='/MedusaLibrary/progetto5e/immagini/icona_biblio.svg' alt=''>
                        <p>Lista Libri</p>
                        <span>></span>
                    </a>
    

                    <a href='/MedusaLibrary/progetto5e/prenotazione/prenotazione.php' class='sub-menu-link'>
                        <img src='/MedusaLibrary/progetto5e/immagini/booking.png' alt=''>
                        <p>Prenotazioni</p>
                        <span>></span>
                    </a>"
                    ;
            if ($utente["Utenza"] == 1 || $utente["Utenza"] == 2) {
                echo "<a href='/MedusaLibrary/progetto5e/dashboard/dashboard.php' class='sub-menu-link'>
                            <img src='/MedusaLibrary/progetto5e/immagini/dashboard.png' alt=''>
                            <p>Dashboard</p>
                            <span>></span>
                        </a>";
            }
            if ($utente["Utenza"] == 3 || $utente["Utenza"] == 4) {
                echo "<a href='/MedusaLibrary/progetto5e/segnalazione/segnalazione.html' class='sub-menu-link'>
                <img src='/MedusaLibrary/progetto5e/immagini/feedbackFavicon.png' alt=''>
                <p>Segnalazione</p>
                <span>></span>
            </a>";
            }
            echo "<a href='#' class='sub-menu-link'>
                        <form method='POST'  action='/MedusaLibrary/progetto5e/nav/nav.php'><button name='logout'><img src='/MedusaLibrary/progetto5e/immagini/logout-icon.png' alt=''><p class='logoutform'>Logout</p><span>></span>
                        </button></form>
                        
                    </a>
    
                </div>
            </div>
        </div>
     </nav>";
        } else {
            echo "
        <ul>
        <li class='li-icon'><a href='/MedusaLibrary/progetto5e/lista/lista.php'><img src='/MedusaLibrary/progetto5e/immagini/icona_biblio.svg' class='icon' ></a></li>
        <li><img src='/MedusaLibrary/progetto5e/immagini/account-circle-icon.png' alt='' class='icon' onclick='toggleMenu()' ></li>
        
        <div class='sub-menu-wrap' id='subMenu'>
            <div class='sub-menu'>

            <a href='/MedusaLibrary/progetto5e/autenticazione/Login.php' class='sub-menu-link'>
                <img src='/MedusaLibrary/progetto5e/immagini/logout-icon.png' alt='login'>
                <p>Login</p>
                <span>></span>
            </a>

            </div>
        </div>
    </div>
 </nav>";

        }

        ?>


        <script>
            let subMenu = document.getElementById("subMenu");

            function toggleMenu() {
                subMenu.classList.toggle("open-menu");
            }
        </script>




        <form  onclick="history.back()" class="form-icon-back">
            <img src="/MedusaLibrary/progetto5e/immagini/arrow.png" alt="" class="icon-back">
        </form>
</body>

</html>
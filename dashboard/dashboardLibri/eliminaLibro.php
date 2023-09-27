<?php
$isbn = $_GET['id'];
require_once("../../things/Connect.php");

$table = "copiaLibro";
$disponibile = 1;

$query3 = "SELECT count(*) AS disponibili FROM $table WHERE ISBN = $isbn AND Stato = $disponibile";
$result3 = mysqli_query($conn, $query3);
$row3 = mysqli_fetch_assoc($result3);
$copieDisponibili = $row3['disponibili'];

if (isset($_POST['elimina'])) {

    $n = $_POST['qty'];
    if ($n != $copieDisponibili) {
        for ($i = 0; $i < $n; $i++) {
            $query4 = "SELECT min(idCopia) AS id FROM copiaLibro WHERE Stato = 1 and ISBN = $isbn";
            $result4 = mysqli_query($conn, $query4);
            $row4 = mysqli_fetch_assoc($result4);
            $idCopia = $row4['id'];

            $query2 = "DELETE FROM copiaLibro WHERE idCopia = $idCopia";
            mysqli_query($conn, $query2);
        }

        echo '<center><h3 style="color: red;">Copia/e eliminata/e</h3></center>';
    } else {

        //Eliminazione file copertina
        $query = "SELECT Copertina FROM Opera WHERE ISBN = $isbn";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $file_path = "../../" . $row['Copertina'];
        mysqli_free_result($result);
        if (file_exists($file_path)) {
        unlink($file_path);
        }
        
        //Eliminazione dati libro da database e reset autoincrement per corretto funzionamento "Ultime Aggiunte | Home"
        $query2 = "DELETE FROM Opera WHERE ISBN = '$isbn'";
        mysqli_query($conn, $query2);
        mysqli_close($conn);
        echo '<center><h3 style="color: red;">Copia/e e relativo Opera eliminate</h3></center>';
    }

    mysqli_close($conn);
    unset($_POST['elimina']);
    unset($_POST['qty']);
    
    echo '<meta http-equiv="refresh" content="1;url=dashboardLibri.php"> ';
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../dashboardUtenti/style.css">
    <link rel="stylesheet" href="../../nav/nav.css">
    <link rel="stylesheet" href="../../things/colors.css">
    <link rel="stylesheet" href="../../things/popup.css">
    <title>Elimina Libro</title>
</head>

<body>
    <div class="pop-up" id="modal">
        <h4>Sei sicuro di voler eliminare il libro:</h4>
        <div class="prenotation-info">
            <?php
            $query1 = "SELECT Nome FROM Opera WHERE ISBN = $isbn";
            $result1 = mysqli_query($conn, $query1);
            $row1 = mysqli_fetch_assoc($result1);
            mysqli_close($conn);
            echo "
                 <span>Titolo: " . $row1['Nome'] . "</span>
                 <span>ISBN: " . $isbn . "</span>
                 ";
            ?>
        </div>

        <?php
        echo "<form class='form' action='eliminaLibro.php?id=" . $isbn . "' method='post'>";
        ?>
        <div class="form-group">
            <label for="qty">Quantità da eliminare (disponibili:
                <?php echo $copieDisponibili; ?>):
            </label>
            <input type="number" class="form-control" id="qty" name="qty" value="1" min="1"
                max="<?php echo $copieDisponibili; ?>" step="1" style="width: 50%; display: inline;" required>
        </div>
        <button class='button' type='submit' name='elimina'>si</button>
        </form>

        <form class='form' action='dashboardLibri.php' method='post'>
            <button class='button' type='submit'>no</button>
        </form>

    </div>
</body>

</html>
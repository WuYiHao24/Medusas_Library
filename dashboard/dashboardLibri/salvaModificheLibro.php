<?php 
require("../../things/Connect.php");

$titolo = $_POST["titolo"];
$autore = $_POST["autore"];
$genere = $_POST["genere"];
$desc = addslashes($_POST["desc"]);
$casaed = $_POST["casaed"];
$annopub = $_POST["annopub"];
$isbn = $_POST["id"];
$isbn_new= $_POST["isbn"];

echo $titolo.$autore.$genere.$desc.$casaed.$annopub.$isbn;

$query = "UPDATE Opera SET ISBN=$isbn_new, Nome='$titolo', Autore='$autore', Genere='$genere', Descrizione='$desc', CasaEditrice='$casaed', AnnoPubblicazione=$annopub WHERE ISBN=$isbn";
header("Location: dashboardLibri.php");


// $sql="UPDATE Opera SET ISBN=$isbn, Nome="$titolo", Autore="$autore", Genere="$genere", Descrizione="$desc", CasaEditrice="$casaed", AnnoPubblicazione=$annopub WHERE ISBN=$isbn";

$conn->query($query);


?>
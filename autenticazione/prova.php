<?php

require_once("../things/Connect.php");

$result = mysqli_query($conn, "SELECT count(*) FROM Opera");
$rows = mysqli_num_rows($result);
printf("Result set has %d rows.\n", $rows);

$conn->close();
?>
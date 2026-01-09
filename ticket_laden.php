<?php
header("Content-Type: application/json");
include("verbindungsdaten.inc");

$db = mysqli_connect($db_server, $db_user, $db_passwort, $db_name);
mysqli_set_charset($db,"utf8");

$tid = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "
    SELECT tid, titel, beschreibung, priorität AS prioritaet, datum
    FROM ticket
    WHERE tid = $tid
    LIMIT 1
";

$result = mysqli_query($db,$query);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode($row);
} else {
    echo json_encode([]);
}

mysqli_close($db);

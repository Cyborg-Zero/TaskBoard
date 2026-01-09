<?php
    //
    include("verbindungsdaten.inc");
    //
    if (isset($_POST['tid'])) {
        $tid = (int)$_POST['tid'];
        //
        $db = mysqli_connect($db_server,$db_user,$db_passwort,$db_name);
        mysqli_set_charset($db,"utf8");
        //
        $query = "DELETE FROM ticket WHERE tid = $tid";
        $result = mysqli_query($db, $query);
        //
        if ($result) {
            echo "Ticket $tid gelöscht";
        } else {
            echo "Fehler: " . mysqli_error($db);
        }
        //
        mysqli_close($db);
    }
?>
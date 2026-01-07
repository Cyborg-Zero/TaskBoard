<?php
    //
    if (isset($_POST['erstellen'])) {
        if (ticket_erstellen()) {
            header("Location: board.php");
            exit;
        }
    }
    //
    function datenbank_verbinden() {
        //
        include("verbindungsdaten.inc");
        //
        $db_verbindung=@mysqli_connect($db_server,$db_user,$db_passwort,$db_name);
        if (!$db_verbindung)
            die("Der Server kann nicht erreicht werden.");
        mysqli_set_charset($db_verbindung,"utf8");
        return $db_verbindung;
    }
    //
    function ticket_erstellen() {
        $verbindungskennung = datenbank_verbinden();
        if (check_einträge() && ticket_schreiben($verbindungskennung)) {
            mysqli_close($verbindungskennung);
            return true;
        }
        return false;
    }
    //
    function check_einträge() {
        if (empty($_POST['titel'])) {
            return false;
        }
        if (empty($_POST['desc'])) {
            return false;
        }
        if (empty($_POST['prio'])) {
            return false;
        }
        return true;
    }
    //
    function ticket_schreiben($p_verbindungskennung) {
        $query = sprintf("INSERT INTO ticket
                        SET titel='%s',
                            beschreibung='%s',
                            priorität='%s',
                            datum=NOW()",
                        mysqli_real_escape_string($p_verbindungskennung, $_POST['titel']),
                        mysqli_real_escape_string($p_verbindungskennung, $_POST['desc']),
                        mysqli_real_escape_string($p_verbindungskennung, $_POST['prio']));
        //
        $ergebnis = mysqli_query($p_verbindungskennung, $query);
        return $ergebnis;
    }   
?>
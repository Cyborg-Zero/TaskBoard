<?php
    //
    if (isset($_POST['bearbeiten'])) {
        if (ticket_bearbeiten()) {
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
    function film_infos(&$p_infos,$p_verbindungskennung) {
        $query="SELECT filmID, titel, filmlänge, erscheinungsjahr, genre.bezeichnung, altersfreigabe
                FROM film
                JOIN genre
                ON film.genreID = genre.genreID
                WHERE titel = '$_POST[titel_ä]'";
        //
        $ergebnis=mysqli_query($p_verbindungskennung,$query);
        $p_infos=array();
        //
        while($zeile=mysqli_fetch_array($ergebnis, MYSQLI_ASSOC)) {
            $p_infos[] = array(
            'id_ä' => $zeile['filmID'],
            'titel_ä' => $zeile['titel'],
            'filmlänge_ä' => $zeile['filmlänge'],
            'erscheinungsjahr_ä' => $zeile['erscheinungsjahr'],
            'bezeichnung_ä' => $zeile['bezeichnung'],
            'altersfreigabe_ä' => $zeile['altersfreigabe']
        }
    }
    //
    function ticket_bearbeiten() {
        $verbindungskennung = datenbank_verbinden();
        if (ticket_sbearbeiten($verbindungskennung)) {
            mysqli_close($verbindungskennung);
            return true;
        }
        return false;
    }
    //
    function ticket_sbearbeiten($p_verbindungskennung) {
        $query = sprintf("UPDATE ticket
                        SET titel='%s',
                            beschreibung='%s',
                            priorität='%s'
                        WHERE tid='$_POST[tid]'",
                        mysqli_real_escape_string($p_verbindungskennung, $_POST['titel']),
                        mysqli_real_escape_string($p_verbindungskennung, $_POST['desc']),
                        mysqli_real_escape_string($p_verbindungskennung, $_POST['prio']));
        //
        $ergebnis = mysqli_query($p_verbindungskennung, $query);
        return $ergebnis;
    }
?>
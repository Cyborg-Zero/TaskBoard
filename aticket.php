<?php
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

    function tickets_abrufen() {
        //Datenbank-Parameter
            include("verbindungsdaten.inc");
        //mit der Datenbank verbinden
        $verbindung=mysqli_connect($db_server,$db_user,$db_passwort,$db_name);
        if (!$verbindung)
            die("Der Server kann nicht erreicht werden.");
        mysqli_set_charset($verbindung,"utf8");
        //Filme aus der Datenbank holen
        $query="SELECT tid,titel,bezeichnung,priorität,datum 
            FROM ticket
            ORDER BY tid";
        $ergebnis=mysqli_query($verbindung,$query);
        if(!$ergebnis)
            echo mysqli_error();
        //und in die Arrays $titel u. $filmlänge schreiben
            $tid=array();
            $titel=array();
            $beschreibung=array();
            $priorität=array();
            $datum=array();
        //
        $i=0;
        while($zeile=mysqli_fetch_array($ergebnis)) {
            $tid[$i]=$zeile[0];
            $titel[$i]=$zeile[1];
            $beschreibung[$i]=$zeile[2];
            $priorität[$i]=$zeile[3];
            $datum[$i]=$zeile[4];
            $i++;
        }
        mysqli_free_result($ergebnis);
        //Ausgabe der Filme
        $i=0;
        //
        echo"<table id=\"tabelle\">";
        echo"<tr class=\"header\">
                <th class=\"tid\">ID</th>
                <th class=\"titel\">Titel</th>
                <th class=\"desc\">Beschreibung</th>
                <th class=\"prio\">Priorität</th>
                <th class=\"date\">Datum</th>
            </tr>";
        while($i<count($tid)) {
            echo "<tr>
                <td class=\"tid\">$tid[$i]</td>
                <td class=\"titel\">$titel[$i]</td>
                <td class=\"desc\">$beschreibung[$i]</td>
                <td class=\"prio\">$priorität[$i]</td>
                <td class=\"date\">$datum[$i]</td>
            </tr>";
            $i++;
        }
        echo"</table><br>";
        mysqli_close($verbindung);
    }

    function ticket_erstellen($p_verbindungskennung) {
        //
        $ergebnis=mysqli_query($p_verbindungskennung,$query);
        $zeile=mysqli_fetch_array($ergebnis);
        //
        $query=sprintf("INSERT INTO ticket
        SET titel='%s',
        beschreibung=%s,
        priorität=%s,
        datum=NOW()",
            $_POST['titel'],
            $_POST['beschreibung'],
            $_POST['priorität']);
        $ergebnis=mysqli_query($p_verbindungskennung,$query);
        echo"<div class=\"formPopup\">Der Film wurde angelegt.</div>";
        mysqli_close($p_verbindungskennung);
    }
?>
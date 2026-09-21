<?php
    //
    if (isset($_POST['bearbeiten'])) {
        if (ticket_bearbeiten()) {
            header("Location: a_board.php");
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
    function ticket_infos(&$p_infos,$p_verbindungskennung) {
        $query="SELECT tid, titel, beschreibung, priorität, datum
                FROM ticket
                WHERE tid = '$_POST[tid]'";
        //
        $ergebnis=mysqli_query($p_verbindungskennung,$query);
        $p_infos=array();
        //
        while($zeile=mysqli_fetch_array($ergebnis, MYSQLI_ASSOC)) {
            $p_infos[] = array(
            'id' => $zeile['tid'],
            'titel' => $zeile['titel'],
            'beschreibung' => $zeile['beschreibung'],
            'priorität' => $zeile['priorität'],
            'datum' => $zeile['datum'],
            );
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
        try {
            // SQL-Query mit Platzhaltern für Prepared Statement vorbereiten
            $sql = "UPDATE ticket 
                    SET titel = ?, 
                        beschreibung = ?, 
                        priorität = ?
                    WHERE tid = ?";
            // Prepared Statement erstellen
            $stmt = mysqli_prepare($p_verbindungskennung, $sql);
            // Parameter an Statement binden (sssi = 3 Strings + 1 Integer)
            mysqli_stmt_bind_param($stmt, "sssi",
                $_POST['titel'], 
                $_POST['desc'], 
                $_POST['prio'],
                $_POST['tid']  // tid auch mit Prepared Statement!
            );
            // Statement ausführen
            mysqli_stmt_execute($stmt);
            // Statement-Ressourcen freigeben
            mysqli_stmt_close($stmt);
            // Transaktion bestätigen
            mysqli_commit($p_verbindungskennung);
            // Weiterleitung zur Board-Seite mit Erfolgsmeldung
            header("Location: a_board.php?success=1");
            exit();
        } catch (Exception $e) {
            // Bei Fehler: Transaktion rückgängig machen
            mysqli_rollback($p_verbindungskennung);
            // Weiterleitung mit Fehlermeldung
            header("Location: a_board.php?error=" . urlencode($e->getMessage()));
            exit();
        }
        // Datenbankverbindung schließen
        mysqli_close($p_verbindungskennung);
    }
?>
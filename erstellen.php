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
        if ($_POST['prio'] === "Priorität wählen") {
            return false;
        }
        return true;
    }
    //
    function ticket_schreiben($p_verbindungskennung) {
        try {
            // SQL-Query mit Platzhaltern für Prepared Statement vorbereiten
            $sql = "INSERT INTO ticket (titel, beschreibung, priorität, datum) 
                    VALUES (?, ?, ?, NOW())";
            // Prepared Statement erstellen
            $stmt = mysqli_prepare($p_verbindungskennung, $sql);
            // Parameter an Statement binden (sss = 3 Strings)
            mysqli_stmt_bind_param($stmt, "sss", 
                $_POST['titel'], 
                $_POST['desc'], 
                $_POST['prio']);
            // Statement ausführen
            mysqli_stmt_execute($stmt);
            // Statement-Ressourcen freigeben
            mysqli_stmt_close($stmt);
            // Transaktion bestätigen
            mysqli_commit($p_verbindungskennung);
            // Weiterleitung zur Board-Seite mit Erfolgsmeldung
            header("Location: board.php?success=1");
            exit(); // Script-Ausführung beenden
        } catch (Exception $e) {
            // Bei Fehler: Transaktion rückgängig machen
            mysqli_rollback($p_verbindungskennung);
            // Weiterleitung mit Fehlermeldung
            header("Location: board.php?error=" . urlencode($e->getMessage()));
            exit();
        }
    // Datenbankverbindung schließen
    mysqli_close($p_verbindungskennung);
    }
?>
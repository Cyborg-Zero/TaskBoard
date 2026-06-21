<?php
    //
    include("verbindungsdaten.inc");
    //
    if (isset($_POST['tid'])) {
        $tid = (int)$_POST['tid'];
        //
        $db = mysqli_connect($db_server, $db_user, $db_passwort, $db_name);
        mysqli_set_charset($db, "utf8");
        // Start transaction
        mysqli_begin_transaction($db);
        //
        try {
            // Insert into archiv
            $insert = "INSERT INTO archiv (tid, titel, beschreibung, priorität, datum, archiviert)
                    SELECT tid, titel, beschreibung, priorität, datum, NOW()
                    FROM ticket WHERE tid = ?";
            $stmt_insert = mysqli_prepare($db, $insert);
            mysqli_stmt_bind_param($stmt_insert, "i", $tid);
            mysqli_stmt_execute($stmt_insert);
            // Delete from ticket
            $delete = "DELETE FROM ticket WHERE tid = ?";
            $stmt_delete = mysqli_prepare($db, $delete);
            mysqli_stmt_bind_param($stmt_delete, "i", $tid);
            mysqli_stmt_execute($stmt_delete);
            // Commit on success
            mysqli_commit($db);
            echo "Ticket $tid archiviert";
        } catch (Exception $e) {
            // Rollback falls Fehler
            mysqli_rollback($db);
            echo "Fehler: " . $e->getMessage();
        }
        //
        mysqli_close($db);
    }
?>   
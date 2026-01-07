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
    //
    function ticket_infos{
            <div class="b_formPopup" id="b_popup">
                <form action="bearbeiten.php" method="post" class="formContainer">
                    <h2>Ticket bearbeiten</h2>
                    <input id="titel" placeholder="Titel eingeben" name="titel" required>
                    <textarea id="desc" placeholder="Beschreiben Sie was passiert ist?" name="desc" required></textarea>
                    <div class="prio-select">
                        <select id="prio" name="prio" required>
                            <option class="dprio" value="Keine" selected disabled hidden>Priorität wählen</option>
                            <option class="dprio" name="prio" value="Hoch">Hoch</option>
                            <option class="dprio" name="prio" value="Mittel">Mittel</option>
                            <option class="dprio" name="prio" value="Niedrig">Niedrig</option>
                        </select>
                    </div>
                    <button type="submit" class="btn" name="bearbeiten">Ticket bearbeiten</button>
                    <button type="submit" class="btn" name="löschen">Ticket schließen</button>
                    <button type="button" class="btn cancel" onclick="closeForm()">Abbrechen</button>
                </form>
            </div>
    }
    //         
?>
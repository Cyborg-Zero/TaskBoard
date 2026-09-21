<!DOCTYPE html>
<html>
    <head>
        <title>TaskBoard</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="CyborgZero">
        <meta name="color-scheme" content="light dark">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script type="module" src="js/main.js"></script>
    </head>
    <body>
        <header>
            <h1>TaskBoard - Archiv</h1>
        </header>
        <div class="liste">
            <div class="suche">
                <input type="text" id="suche" oninput="Suchen()" placeholder="Suche nach Tickets" title="Tippe ein Suchbegriff ein" size="50">
                <a href="board.php">
                    <input type="button" value="Aktuelle Tickets">
                </a>
                <input type="button" onclick="openForm()" id="erstellen" value="Ticket erstellen">
            </div>
            <div class="tabelle">
                <?php
                    include("verbindungsdaten.inc");
                    require ('archiv.php');
                    //
                    echo tickets_abrufen();
                ?>
            </div>
            <div class="ticketPopup">
                <div class="formPopup" id="popup">
                    <form action="erstellen.php" method="post" class="formContainer">
                        <h2>Ticket erstellen</h2>
                        <input id="titel" placeholder="Titel eingeben" name="titel" required>
                        <textarea id="desc" placeholder="Beschreiben Sie was passiert ist?" name="desc" required></textarea>
                            <select id="prio" name="prio" required>
                                <option value="" selected disabled hidden>Priorität wählen</option>
                                <option value="Hoch">Hoch</option>
                                <option value="Mittel">Mittel</option>
                                <option value="Niedrig">Niedrig</option>
                            </select>
                        <button type="submit" class="btn" name="erstellen">Ticket erstellen</button>
                        <button type="button" class="btn_cancel" onclick="closeForm()">Close</button>
                    </form>
                </div>
                <div class="b_formPopup" id="b_popup">
                    <form action="nachlesen.php" method="post" class="formContainer">
                        <h2>Ticket bearbeiten</h2>
                            <input type="hidden" id="ticket_id" name="tid">
                            <input id="b_titel" name="titel" required>
                            <textarea id="b_desc" name="desc" required></textarea>
                            <select id="b_prio" name="prio" required>
                                <option value="" selected disabled hidden>Priorität wählen</option>
                                <option value="Hoch">Hoch</option>
                                <option value="Mittel">Mittel</option>
                                <option value="Niedrig">Niedrig</option>
                            </select>
                        <button type="button" class="btn_cancel" onclick="closebForm()">Abbrechen</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
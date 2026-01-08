<?php
// AJAX-Datei: Ticket-Daten laden
header("Content-Type: application/json");
// Datenbank verbinden
function datenbank_verbinden() {
    //
    include("verbindungsdaten.inc");
    //
    $db_verbindung = @mysqli_connect(
        $db_server,
        $db_user,
        $db_passwort,
        $db_name
    );
    //
    if (!$db_verbindung) {
        echo json_encode(array(
            "error" => "Der Server kann nicht erreicht werden."
        ));
        exit;
    }
    //
    mysqli_set_charset($db_verbindung, "utf8");
    //
    return $db_verbindung;
}
// Ticket-Infos laden
function ticket_infos(&$p_infos, $p_verbindungskennung, $p_tid) {
    //
    $query = "SELECT tid, titel, beschreibung, priorität, datum
              FROM ticket
              WHERE tid = ?";
    //
    $stmt = mysqli_prepare($p_verbindungskennung, $query);
    mysqli_stmt_bind_param($stmt, "i", $p_tid);
    mysqli_stmt_execute($stmt);
    //
    $ergebnis = mysqli_stmt_get_result($stmt);
    //
    $p_infos = array();
    //
    if ($zeile = mysqli_fetch_array($ergebnis, MYSQLI_ASSOC)) {
        $p_infos = array(
            "tid"         => $zeile["tid"],
            "titel"       => $zeile["titel"],
            "beschreibung"=> $zeile["beschreibung"],
            "prioritaet"  => $zeile["priorität"],
            "datum"       => $zeile["datum"]
        );
    }
}
// Hauptprogramm
$db = datenbank_verbinden();

$tid = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

$ticket = array();
ticket_infos($ticket, $db, $tid);

echo json_encode($ticket);

<?php
// ticket_laden.php - Sichere JSON-Ausgabe eines einzelnen Tickets

header("Content-Type: application/json");
include("verbindungsdaten.inc");

// Verbindung zur Datenbank
$db = mysqli_connect($db_server, $db_user, $db_passwort, $db_name);
mysqli_set_charset($db, "utf8");

// ID holen und sicher in Integer umwandeln
$tid = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// SQL-Vorbereitung (Prepared Statement) zum Schutz vor SQL-Injection
$query = "SELECT tid, titel, beschreibung, priorität, status, datum 
          FROM ticket 
          WHERE tid = ? LIMIT 1";
$stmt = mysqli_prepare($db, $query);

if ($stmt) {
    // Parameter binden ("i" = Integer)
    mysqli_stmt_bind_param($stmt, "i", $tid);
    
    // Ausführen
    mysqli_stmt_execute($stmt);
    
    // Ergebnis holen
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {

        // $row['prioritaet'] = $row['priorität']; unset($row['priorität']);
        
        echo json_encode($row, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode([]);
    }
    
    mysqli_stmt_close($stmt);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Fehler beim Datenbankzugriff"]);
}

mysqli_close($db);
?>
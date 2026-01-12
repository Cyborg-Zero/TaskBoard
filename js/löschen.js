window.loescheTicket = function() {
    const tid = document.getElementById("ticket_id").value;
    if (!tid) return;
    //
    if (!confirm("Willst du dieses Ticket wirklich löschen?")) return;
    //
    fetch("ticket_loeschen.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "tid=" + encodeURIComponent(tid)
    })
    .then(res => res.text())
    .then(response => {
        console.log("Löschen-Response:", response);
        // Pop-up schließen
        closebForm();
        // Tabelle neu laden
        location.reload(); // einfacher Weg, damit Tabelle aktuell ist
    })
    .catch(err => console.error("Fehler beim Löschen:", err));
}
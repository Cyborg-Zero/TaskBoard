// Pop-up öffnen und Ticket laden
window.openbForm = function(tid) {
    console.log("Aufruf von a_ticket_laden.php mit ID:", tid);
    //
    fetch("a_ticket_laden.php?id=" + tid)
        .then(res => res.json())
        .then(ticket => {
            // --- NEU: Rohdaten für den JSON-Export zwischenspeichern ---
            // Enthält u.a. 'datum' und 'archiviert' aus der DB
            window._archivTicketRohdaten = ticket;
            // ------------------------------------------------------------

            // Pop-up zuerst sichtbar machen
            const popup = document.getElementById("a_popup");
            popup.style.display = "block";
            //Zum Debuggen
            console.log("Ticket geladen:", ticket); // Debug
            console.log("Titel-Feld:", document.getElementById("a_titel"));
            console.log("Beschreibung-Feld:", document.getElementById("a_desc"));
            console.log("Priorität-Feld:", document.getElementById("a_prio"));
            console.log("Status-Feld:", document.getElementById("a_status"));
            //Titel des Tickets
            const titelInput = document.getElementById("a_titel");
            if (titelInput) titelInput.value = ticket.titel || "";
            // Textarea Beschreibung
            const descInput = document.getElementById("a_desc");
            if (descInput) descInput.value = ticket.beschreibung || "";
            // Hidden Feld Ticket-ID
            const ticketIdInput = document.getElementById("ticket_id");
            if (ticketIdInput) ticketIdInput.value = ticket.tid || "";
            // Hidden Feld Datum
            const datumInput = document.getElementById("a_datum");
            if (datumInput) datumInput.value = ticket.datum || "";
            // Select Priorität
            const prioSelect = document.getElementById("a_prio");
            if (prioSelect) {
                let found = false;
                for (let i = 0; i < prioSelect.options.length; i++) {
                    console.log("Option Value:", prioSelect.options[i].value, "Ticket Priorität:", ticket.priorität); // Debug
                    if (prioSelect.options[i].value === ticket.priorität) {
                        prioSelect.selectedIndex = i;
                        found = true;
                        break;
                    }
                }
                if (!found) prioSelect.selectedIndex = 0; // Standard auswählen, falls nicht gefunden
            };
            const statusSelect = document.getElementById("a_status");
            if (statusSelect) {
                // 1. Hole den Rohwert aus dem JSON
                const ticketStatusRaw = ticket.status; 
                
                // 2. Fallback: Wenn status nicht existiert, versuche Status (Groß/S Klein)
                const ticketStatus = ticketStatusRaw !== undefined 
                    ? ticketStatusRaw 
                    : (ticket['Status'] !== undefined ? ticket['Status'] : (ticket['status_id'] !== undefined ? String(ticket['status_id']) : ""));

                console.log("Roh-Status aus JSON:", JSON.stringify(ticketStatus)); // Hier siehst du den echten Wert!

                const ziel = String(ticketStatus).trim(); // Nur Leerzeichen entfernen, Groß/Klein behalten!

                let found = false;
                for (let i = 0; i < statusSelect.options.length; i++) {
                    const optVal = statusSelect.options[i].value;
                    const optText = statusSelect.options[i].text;
                    
                    // Vergleich: Wert ODER Text des Options (wegen Tippfehlern im HTML)
                    if (optVal.trim() === ziel || optText.trim() === ziel) {
                        statusSelect.selectedIndex = i;
                        found = true;
                        console.log("✅ Status gefunden: " + ziel);
                        break;
                    }
                }

                if (!found) {
                    console.error("❌ Status NICHT gefunden. Erwartet:", JSON.stringify(ziel));
                    console.error("   Verfügbare Optionen im HTML:", [...statusSelect.options].map(o => o.value));
                    // Fallback: erstes Feld
                    statusSelect.selectedIndex = 0;
                }
            }
        })
    .catch(err => console.error("Fehler beim Laden des Tickets:", err));
}
// Klick-Listener für Bearbeiten-Buttons
document.addEventListener("click", function (e) {
    const btn = e.target.closest(".nachlesen");
    if (!btn) return;

    const tid = btn.dataset.tid;
    if (!tid) return;

    openbForm(tid);
});
// Pop-up schließen
window.closebForm = function() {
    const popup = document.getElementById("a_popup");
    if (popup) popup.style.display = "none";

    // --- NEU: Archiv-Rohdaten verwerfen ---
    // Verhindert, dass beim nächsten Export versehentlich alte Daten genutzt werden
    window._archivTicketRohdaten = null;
};
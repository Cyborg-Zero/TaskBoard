// Pop-up öffnen und Ticket laden
window.openbForm = function(tid) {
    console.log("Aufruf von ticket_laden.php mit ID:", tid);
    //
    fetch("ticket_laden.php?id=" + tid)
        .then(res => res.json())
        .then(ticket => {
            // Pop-up zuerst sichtbar machen
            const popup = document.getElementById("b_popup");
            popup.style.display = "block";
            //
            console.log("Ticket geladen:", ticket); // Debug
            console.log("Titel-Feld:", document.getElementById("b_titel"));
            console.log("Beschreibung-Feld:", document.getElementById("b_desc"));
            console.log("Priorität-Feld:", document.getElementById("b_prio"));
            //
            const titelInput = document.getElementById("b_titel");
            if (titelInput) titelInput.value = ticket.titel || "";
            // Textarea Beschreibung
            const descInput = document.getElementById("b_desc");
            if (descInput) descInput.value = ticket.beschreibung || "";
            // Hidden Feld Ticket-ID
            const ticketIdInput = document.getElementById("ticket_id");
            if (ticketIdInput) ticketIdInput.value = ticket.tid || "";
            // Select Priorität
            const prioSelect = document.getElementById("b_prio");
            if (prioSelect) {
                let found = false;
                for (let i = 0; i < prioSelect.options.length; i++) {
                    console.log("Option Value:", prioSelect.options[i].value, "Ticket Priorität:", ticket.prioritaet); // Debug
                    if (prioSelect.options[i].value === ticket.prioritaet) {
                        prioSelect.selectedIndex = i;
                        found = true;
                        break;
                    }
                }
                if (!found) prioSelect.selectedIndex = 0; // Standard auswählen, falls nicht gefunden
            }
        })
    .catch(err => console.error("Fehler beim Laden des Tickets:", err));
}
// Klick-Listener für Bearbeiten-Buttons
document.addEventListener("click", function (e) {
    const btn = e.target.closest(".bearbeiten");
    if (!btn) return;

    const tid = btn.dataset.tid;
    if (!tid) return;

    openbForm(tid);
});
// Pop-up schließen
window.closebForm = function() {
    const popup = document.getElementById("b_popup");
    if (popup) popup.style.display = "none";
}
function exportTicket() {
    const tid          = document.getElementById("ticket_id")?.value || "";
    const titel        = document.getElementById("b_titel")?.value || "";
    const beschreibung = document.getElementById("b_desc")?.value || "";
    const prioritaet   = document.getElementById("b_prio")?.value || "";
    const status       = document.getElementById("b_status")?.value || "";
    const datum        = document.getElementById("b_datum")?.value || ""; // NEU

    if (!tid) {
        alert("Kein Ticket ausgewählt. Bitte öffnen Sie zuerst ein Ticket.");
        return;
    }

    const ticketDaten = {
        tid: tid,
        titel: titel,
        beschreibung: beschreibung,
        priorität: prioritaet,
        status: status,
        datum: datum,             // ← Ticket-Erstellungsdatum
        exportDatum: new Date().toISOString()
    };

    const jsonString = JSON.stringify(ticketDaten, null, 2);
    const blob = new Blob([jsonString], { type: "application/json;charset=utf-8" });
    const url  = URL.createObjectURL(blob);

    const link = document.createElement("a");
    link.href = url;
    link.download = `ticket_${tid}.json`;

    document.body.appendChild(link);
    link.click();

    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}

window.exportTicket = exportTicket;
// export.js

window.exportTicket = function() {
    // 1. Kontext erkennen
    const istArchiv = !!document.getElementById("a_prio");

    // 2. Feld-IDs je nach Popup
    const ids = istArchiv ? {
        tid:          "ticket_id",
        titel:        "a_titel",
        beschreibung: "a_desc",
        prioritaet:   "a_prio",
        status:       "a_status"
    } : {
        tid:          "ticket_id",
        titel:        "b_titel",
        beschreibung: "b_desc",
        prioritaet:   "b_prio",
        status:       "b_status"
    };

    // 3. Formularwerte lesen
    const getVal = (id) => document.getElementById(id)?.value || "";

    const tid          = getVal(ids.tid);
    const titel        = getVal(ids.titel);
    const beschreibung = getVal(ids.beschreibung);
    const prioritaet   = getVal(ids.prioritaet);
    const status       = getVal(ids.status);

    if (!tid) {
        alert("Kein Ticket ausgewählt. Bitte öffnen Sie zuerst ein Ticket.");
        return;
    }

    // 4. Basisobjekt
    const ticketDaten = {
        tid: tid,
        titel: titel,
        beschreibung: beschreibung,
        priorität: prioritaet,
        status: status,
        exportDatum: new Date().toISOString()
    };

    // 5. Datumsfelder ergänzen
    if (istArchiv && window._archivTicketRohdaten) {
        // Keys passen exakt zu deiner SQL-Abfrage: datum, archiviert
        ticketDaten.datum        = window._archivTicketRohdaten.datum || "";
        ticketDaten.archiviertAm = window._archivTicketRohdaten.archiviert || "";
    } else {
        // Normaler Bearbeiten-Kontext
        const datumInput = document.getElementById("b_datum");
        if (datumInput?.value) {
            ticketDaten.datum = datumInput.value;
        }
    }

    // 6. Download auslösen
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

    console.log(`Ticket ${tid} erfolgreich exportiert (${istArchiv ? "Archiv" : "Bearbeiten"}).`);
};
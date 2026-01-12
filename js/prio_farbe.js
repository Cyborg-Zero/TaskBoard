//
//function prio_color() {
    //Es wird gewartet bis die ganze Seite geladen ist
    document.addEventListener("DOMContentLoaded", () => {
        //Neue Konstante für td.prio Infos
        const prioFelder = document.querySelectorAll("td.prio");
        //Log zum debuggen
        console.log("Gefundene Prio-Felder:", prioFelder.length);
        //
        prioFelder.forEach(feld => {
            const wert = feld.textContent.trim();
            //
            console.log("Priorität:", wert);
            //
            feld.classList.remove("prio-hoch", "prio-mittel", "prio-niedrig");
            //
            if (wert === "Hoch") {
                feld.classList.add("prio-hoch");
            } else if (wert === "Mittel") {
                feld.classList.add("prio-mittel");
            } else if (wert === "Niedrig") {
                feld.classList.add("prio-niedrig");
            }
        });
    });
//}
  
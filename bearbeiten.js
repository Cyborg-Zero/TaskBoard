//
function openbForm(tid) {
    fetch("ticket_laden.php?id=" + tid)
        .then(response => response.json())
        .then(ticket => {

            document.getElementById("titel").value = ticket.titel;
            document.getElementById("desc").value = ticket.beschreibung;
            document.getElementById("prio").value = ticket.prioritaet;
            document.getElementById("ticket_id").value = ticket.tid;

            document.getElementById("b_popup").style.display = "block";
        });
}
//
function closebForm() {
    document.getElementById("b_popup").style.display = "none";
}

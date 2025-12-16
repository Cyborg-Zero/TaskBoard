function myFunction() {
    var input, filter, table, tr, td, i, j;
    input = document.getElementById("suche");
    filter = input.value.toUpperCase();
    table = document.getElementById("tabelle");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                break;
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}   
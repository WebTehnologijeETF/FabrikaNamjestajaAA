function ucitajZaglavlje() {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200)
            document.getElementById("zaglavlje").innerHTML = ajax.responseText;
        if (ajax.readyState == 4 && ajax.status == 404)
            document.getElementById("zaglavlje").innerHTML = imeStranice;
    }
    ajax.open("GET", "zaglavlje.html", true);
    ajax.send();
}
function ucitajPodnozje() {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200)
            document.getElementById("podnozje").innerHTML = ajax.responseText;
        if (ajax.readyState == 4 && ajax.status == 404)
            document.getElementById("podnozje").innerHTML = imeStranice;
    }
    ajax.open("GET", "podnozje.html", true);
    ajax.send();
}


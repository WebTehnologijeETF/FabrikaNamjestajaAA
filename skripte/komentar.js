function posaljiKomentar(vijestId) {

    var komentar = {
        vijestid: vijestId,
        autor: document.getElementsByName("komentarIme")[0].value,
        mail: document.getElementsByName("komentarMail")[0].value,
        tekst: document.getElementsByName("komentarTekst")[0].value
    }
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var rez = JSON.parse(ajax.responseText);
            if (rez.OK == "OK") { alert("Komentar je dodan"); }
            else alert("Problem kod unosa!");
        }
        if (ajax.readyState == 4 && ajax.status == 404) {
            document.getElementById('sredina').innerHTML = '<p> Desio se problem </p>';
        }

    }
    ajax.open("POST", "servis/komentar.php", true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("novostid=" + komentar.vijestid + "&autor=" + komentar.autor + "&mail=" + komentar.mail + "&tekst=" + komentar.tekst);

}

function dobaviSveKomentare(vijestId, admin) {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var komentar = JSON.parse(ajax.responseText);
            prikaziSveKomentare(komentar, admin);
        }
        if (ajax.readyState == 4 && ajax.status == 404) {
            document.getElementById('sredina').innerHTML = '<p> Desio se problem </p>';
        }
    }
    ajax.open("GET", 'servis/komentar.php?sta=dobaviSve&vijestId=' + vijestId, true);
    ajax.send();
}

function prikaziSveKomentare(komentar, admin) {
    var sviKomentari = document.createElement("h3");
    sviKomentari.innerHTML = "Svi komentari";

    document.getElementById("novost").appendChild(sviKomentari);
    for (i = 0; i < komentar.length; i++) {
        prikaziKomentar(komentar[i], admin);
    }
}

function prikaziKomentar(komentar, admin) {
    var komentarDiv = document.createElement("div");
    komentarDiv.setAttribute("id", "komentariNovost");

    var divNaslovKom = document.createElement("div");
    divNaslovKom.setAttribute("id", "naslovKomentara");
    var lista = document.createElement("ul");
    lista.setAttribute("id", "listaKomentar");

    var datum = document.createElement("li");
    datum.innerHTML = komentar.datum;
    lista.appendChild(datum);
    var autor = document.createElement("li");
    autor.innerHTML = komentar.autor;
    lista.appendChild(autor);
    var mail = document.createElement("li");
    mail.innerHTML = komentar.mail;
    lista.appendChild(mail);

    if (admin == true) {
        var brisi = document.createElement("li");
        var aBrisi = document.createElement("a");
        aBrisi.setAttribute("href", "#");
        aBrisi.innerHTML = "Obriši";
        aBrisi.setAttribute("onclick", "obrisiKomentar(" + komentar.id + ")");
        brisi.appendChild(aBrisi);
        lista.appendChild(brisi);
    }

    divNaslovKom.appendChild(lista);


    var tekst = document.createElement("p");
    tekst.setAttribute("class", "tekstVijesti");
    tekst.innerHTML = komentar.tekst;
    komentarDiv.appendChild(divNaslovKom);
    komentarDiv.appendChild(tekst);
    document.getElementById("novost").appendChild(komentarDiv);
}

function obrisiKomentar(id) {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var rez = JSON.parse(ajax.responseText);
            if (rez.OK == "OK") { alert("Komentar je obrisan"); }
            else alert("Problem brisanja");
        }
        if (ajax.readyState == 4 && ajax.status == 404) {
            document.getElementById('ponuda').innerHTML = '<p> Desio se problem </p>';
        }

    }
    ajax.open("DELETE", "servis/komentar.php?id=" + id, true);
    ajax.send();
}
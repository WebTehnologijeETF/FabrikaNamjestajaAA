function dobaviVijest(id, admin) {    
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var vijest = JSON.parse(ajax.responseText);
            
            prikaziVijest(vijest[0], admin);
        }
        if (ajax.readyState == 4 && ajax.status == 404) {
            document.getElementById('sredina').innerHTML = '<p> Desio se problem </p>';
        }
    }
    ajax.open("GET", 'servis/vijest.php?sta=dajVijest&id='+id, true);
    ajax.send();
}

function prikaziVijest(vijest, admin) {    
    var divNovost = document.createElement("div");
    divNovost.setAttribute("id", "novost");

    var divNaslov = document.createElement("div");
    divNaslov.setAttribute("id", "naslovNovost");
    var naslov = document.createElement("h1");
    naslov.innerHTML = vijest.naslov;
    divNaslov.appendChild(naslov);
    divNovost.appendChild(divNaslov);

    var divSlika = document.createElement("div");
    divSlika.setAttribute("id", "slikaNovost");
    var slika = document.createElement("img");
    slika.setAttribute("src", vijest.slika);
    slika.setAttribute("alt", vijest.naslov);
    divSlika.appendChild(slika);
    divNovost.appendChild(divSlika);

    var divTekst = document.createElement("div");
    divTekst.setAttribute("id", "tekstNovost");
    var tekst = document.createElement("p");
    tekst.innerHTML = vijest.tekst;
    var datum = document.createElement("small");
    datum.innerHTML = vijest.datum;
    divTekst.appendChild(tekst);
    divTekst.appendChild(datum);
    divNovost.appendChild(divTekst);

    var divKomentar = document.createElement("div");
    divKomentar.setAttribute("id", "ostaviKomentarNovost");
    divKomentar.setAttribute("style", "float:left;");
    var h3OstaviKomentar = document.createElement("h3");
    h3OstaviKomentar.innerHTML = "Ostavi komentar";
    var pIme = document.createElement("p");
    pIme.innerHTML = "Ime:";
    var ime = document.createElement("input");
    ime.setAttribute("name", "komentarIme");
    var pMail = document.createElement("p");
    pMail.innerHTML = "E-Mail:";
    var mail = document.createElement("input");
    mail.setAttribute("name", "komentarMail");
    var pKomentar = document.createElement("p");
    pKomentar.innerHTML = "Komentar:";
    var komentar = document.createElement("textarea");
    komentar.setAttribute("class", "komentarArea");
    komentar.setAttribute("name", "komentarTekst");
    var btnSubmit = document.createElement("input");
    btnSubmit.setAttribute("type", "button");
    btnSubmit.setAttribute("value", "Pošalji");
    btnSubmit.setAttribute("onclick", "posaljiKomentar(" + vijest.id + ")");
    divKomentar.appendChild(h3OstaviKomentar);
    divKomentar.appendChild(pIme);
    divKomentar.appendChild(ime);
    divKomentar.appendChild(pMail);
    divKomentar.appendChild(mail);
    divKomentar.appendChild(pKomentar);
    divKomentar.appendChild(komentar);
    divKomentar.appendChild(document.createElement("br"));
    divKomentar.appendChild(btnSubmit);
    divNovost.appendChild(divKomentar);

    var brojKomentara = document.createElement("a");
    brojKomentara.setAttribute("style", "padding-left:10px");
    brojKomentara.setAttribute("href", "#");    
    brojKomentara.setAttribute("onclick", "dobaviSveKomentare(" + vijest.id + ", " + admin + ")");
    divNovost.appendChild(brojKomentara);
    dajBrojKomentara(vijest.id, brojKomentara, admin);
    document.getElementById("sredina").innerHTML = "";
    document.getElementById("sredina").appendChild(divNovost);    
}


function dajBrojKomentara(id, brojKomentara, admin) {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var brojK = JSON.parse(ajax.responseText);            
            if (brojK.brojKomentara == 0) brojKomentara.innerHTML = "Nema komentara";            
            else if (brojK.brojKomentara == 1) {
                brojKomentara.innerHTML = brojK.brojKomentara + " komentar";
                brojKomentara.setAttribute("onclick", "dobaviSveKomentare(" + id + ", " + admin + ")");
            }
            else {
                brojKomentara.innerHTML = brojK.brojKomentara + " komentara";
                brojKomentara.setAttribute("onclick", "dobaviSveKomentare(" + id + ", " + admin + ")");
            }
        }
        if (ajax.readyState == 4 && ajax.status == 404) {
            document.getElementById('sredina').innerHTML = '<p> Desio se problem </p>';
        }
    }
    ajax.open("GET", 'servis/vijest.php?sta=dajBrojKomentara&id='+id, true);
    ajax.send();
}

function prikaziKomentare(vijestId, admin) {
    
}



function dobaviNovosti(admin) { //dobavljanje svih novosti, atribut admin je samo indikator da li je neko logovan    
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var vijest = JSON.parse(ajax.responseText);
            prikaziNovosti(vijest, admin);
        }
        if (ajax.readyState == 4 && ajax.status == 404) {
            document.getElementById('ponuda').innerHTML = '<p> Desio se problem </p>';
        }
    }
    ajax.open("GET", 'servis/novost.php?sta=dobaviSve', true);
    ajax.send();
}


function dodajNovost(id) {     // dodavanje novosti za id == null, a uređivanje za id != null
    var novost = {
        naslov: document.getElementsByName("naslov")[0].value,
        tekst: document.getElementsByName("novost")[0].value,
        slika: document.getElementsByName("slika")[0].value
    }
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var rez = JSON.parse(ajax.responseText);
            if(id == null) {
                if (rez.OK == "OK") { alert("Novost je dodana"); dodajJednuNovost(novost, true); }
                else alert("Problem kod unosa!"); 
            }else {
                if (rez.OK == "OK") { alert("Novost je uređena!"); }
                else alert("Problem kod promjene!"); 
            }
        }
        if (ajax.readyState == 4 && ajax.status == 404) {
            document.getElementById('ponuda').innerHTML = '<p> Desio se problem </p>';
        }

    }
    if (id == null) {
        ajax.open("POST", "servis/novost.php", true);
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("naslov=" + novost.naslov + "&tekst=" + novost.tekst + "&slika=" + novost.slika);
    }else {
        jax.open("PUT", "servis/novost.php", true);
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("naslov=" + novost.naslov + "&tekst=" + novost.tekst + "&slika=" + novost.slika + "&id="+id);
    }
}


function prikaziNovosti(vijest, admin) {    //priakaz svih novosti
    for (i = 0; i < vijest.length; i++) {
        dodajJednuNovost(vijest[i], admin);
    }

}

function dodajJednuNovost(vijest, admin) { // kreiranje elementa novosti
    var element = document.createElement("div"); //glavni div
    element.setAttribute("class", "element");

    var id = document.createElement("input"); // ovo i ne treba sad za sad
    id.setAttribute("type", "hidden");
    id.setAttribute("value", vijest.id);

    var link = document.createElement("a"); // link na cijelu vijest
    link.setAttribute("href", "#");

    var naslov = document.createElement("h2"); // naslov
    naslov.innerHTML = vijest.naslov;

    var slika = document.createElement("img"); // slika
    slika.setAttribute("class", "slikaProizvoda");
    slika.setAttribute("src", vijest.slika);
    slika.setAttribute("alt", vijest.naslov);

    link.appendChild(naslov);
    link.appendChild(slika);
    element.appendChild(link);
    element.appendChild(id);

    if (admin == true) {

        var divAdmin = document.createElement("div");
        divAdmin.setAttribute("class", "divAdmin");


        var uredi = document.createElement("a");
        uredi.setAttribute("href", "#");
        uredi.setAttribute("onclick", "popuniPoljaZaUredit("+ vijest.id +")");
        uredi.innerHTML = "Uredi";

        var brisi = document.createElement("a");
        brisi.setAttribute("href", "#");
        brisi.setAttribute("onclick", "brisiNovost(" + vijest.id + ")");
        brisi.innerHTML = "Briši";
        divAdmin.appendChild(uredi);
        divAdmin.appendChild(brisi);
        element.appendChild(divAdmin);
    }

    document.getElementById("ponuda").appendChild(element);
}

function popuniPoljaZaUredit(id) {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var vijest = JSON.parse(ajax.responseText);
            document.getElementsByName("naslov")[0].value = vijest.naslov;
            document.getElementsByName("novost")[0].value = vijest.tekst;
            document.getElementsByName("slika")[0].value = vijest.slika;
            document.getElementsByName("btnSubmit")[0].value = "Uredi";
            document.getElementsByName("btnSubmit")[0].setAttribute("onclick", "dodajNovost(id)");
        }
        if (ajax.readyState == 4 && ajax.status == 404) {
            document.getElementById('ponuda').innerHTML = '<p> Desio se problem </p>';
        }
    }
    ajax.open("GET", 'servis/novost.php?sta=dobaviSve&id=' + id, true);
    ajax.send();
}

function urediNovost(id) {
    dodajNovost(id);
}

function brisiNovost(id) {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var rez = JSON.parse(ajax.responseText);
            if (rez.OK == "OK") { alert("Novost je obrisana"); }
            else alert("Problem brisanja");
        }
        if (ajax.readyState == 4 && ajax.status == 404) {
            document.getElementById('ponuda').innerHTML = '<p> Desio se problem </p>';
        }

    }
    ajax.open("DELETE", "servis/novost.php?id=" + id, true);
    ajax.send();
}
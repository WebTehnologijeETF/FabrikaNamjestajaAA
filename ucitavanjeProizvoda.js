

function dobaviTabelu() {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var tabela = JSON.parse(ajax.responseText);
            kreirajTabelu(tabela);
        }
        if (ajax.readyState == 4 && ajax.status == 404) {
            document.getElementById('ponuda').innerHTML = '<p> Desio se problem </p>';

        }

    }
    ajax.open("GET", 'http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=15987', true);
    ajax.send();
    return false;
}

function kreirajTabelu(tabela) {
    var t = "<table class='kotrolaProizvoda'><tr><td><input type='button' onclick=akcija('dodavanje')  value='Dodaj'> </td><td> <input type='button' onclick=akcija('promjena') value='Promijeni'> </td><td> <input type='button' onclick=akcija('brisanje') value='Briši'></td></tr></table>";
    t += "<p id='opisRadaTabele'> Za unos i promjenu popunite polja u tabeli i kliknite na Dodaj odnosno Promijeni <br> Za brisanje, dovoljno je popunit polje za ID i kliknut na Brisi </p>"; 
    t += '<table id="tabelaProizvoda"> <tr><th>id</th><th>Naziv</th><th>Slika</th><th>Cijena</th> <th>Opis</th></tr>';
    
    t += "<tr><td><input id='id'></td><td><input id='naziv'></td><td><input id='slika' type='file'></td><td><input id='cijena'></td> <td><input id='opis'> </td></tr>"
    for (i = 0; i < tabela.length; i++)
        t += "<tr><td>" + tabela[i].id + "</td> <td>" + tabela[i].naziv + '</td><td>' + tabela[i].slika + '</td><td>' + tabela[i].cijena + '</td><td>' + tabela[i].opis + "</td></tr>";
    t += '</table>';
    document.getElementById('ponuda').innerHTML = t;
}

function validiraj(objekat, tip) {
    if (tip == 'dodavanje' || tip == 'promjena') {
        if (objekat.naziv.length == 0) return "Niste unijeli naziv!";
        if (objekat.slika.length == 0) return "Niste unijeli sliku!";
        if (objekat.cijena == NaN) return "Niste unijelu cijenu!";
        if (objekat.opis.length == 0) return "Niste unijeli opis!";
    }else if(tip == 'brisanje') {
        if(objekat.id == NaN) return "Niste unijeli ID!";
    }

    return "";

}


function akcija(tip) {
    var p = {
        id : parseInt(document.getElementById('id').value),        
        naziv: document.getElementById('naziv').value,
        slika: document.getElementById('slika').value.toString(),
        cijena: parseFloat(document.getElementById('cijena').value),
        opis: document.getElementById('opis').value
    };
    
    
    var rez = validiraj(p, tip);
    if(rez != "") {
        alert(rez);
        return;
    }
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            dobaviTabelu();
            if (tip == 'dodavanje') alert("Proizvod je dodan!");
            if (tip == 'brisanje') alert("Proizvod je obrisan!");
            if (tip == 'promjena') alert("Proizvod je promjenjen!");
        }
        if (ajax.readyState == 4 && ajax.status == 404)
            alert(ajax.responseText.toString());

    }
    ajax.open("POST", "http://zamger.etf.unsa.ba/wt/proizvodi.php", true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("akcija=" + tip + "&brindexa=15987&proizvod=" + JSON.stringify(p));    
}
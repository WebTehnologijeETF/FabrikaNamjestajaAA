function blinkaj(el, interval) {
    return window.setInterval(function () {
        if (el.style.visibility == 'hidden') {
            el.style.visibility = 'visible';
        } else {
            el.style.visibility = 'hidden';
        }
    }, interval);
}

var blinkanje1 = null;
var blinkanje2 = null;

function ispravnostMaila(mail) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(mail);
}

function provjeriMail(el) {
    if (!ispravnostMaila(el.value)) {
        document.getElementById("greskaMail").title = 'E-Mail nije korektan!';
        blinkanje2 = blinkaj(document.getElementById("greskaMail"), 300);
        return false;
    } else {
        clearInterval(blinkanje2);
        document.getElementById("greskaMail").style.visibility = 'hidden';
        return true;
    }
}

function provjeri(el) {
    document.getElementsByClassName("porukaOGresci")[0].style.visibility = 'hidden';
    if (el.value == "") {
        if (el.name == "ime" && blinkanje1 == null) blinkanje1 = blinkaj(document.getElementById("greskaIme"), 300);
        if (el.name == 'mail' && blinkanje2 == null) blinkanje2 = blinkaj(document.getElementById("greskaMail"), 300);
        document.getElementById("poruka").disabled = true;
        return false;
    } else {
        if (el.name == 'ime' && blinkanje1 != null) {
            clearInterval(blinkanje1);
            document.getElementById("greskaIme").style.visibility = 'hidden';
            document.getElementById("poruka").disabled = false;
            return true;
        }
        if (el.name == 'mail') {
            clearInterval(blinkanje2);
            document.getElementById("greskaMail").style.visibility = 'hidden';
            document.getElementById("poruka").disabled = false;
            return provjeriMail(el);
        }

    }
    return true;

}


function provjeraMjestaIOpcine() {
    var mjesto = document.getElementById('mjesto').value;
    var opcina = document.getElementById('opcina').value;
    var servis = "http://zamger.etf.unsa.ba/wt/mjesto_opcina.php?opcina=" + opcina + "&mjesto=" + mjesto;
    if (mjesto.length === 0) {
        alert("Polje za unos mjesta je prazno!");
        return false;
    }
    if (opcina.length === 0) {
        alert("Polje za unos opcine je prezno!");   
        return false;
    }    
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var odgovor = JSON.parse(ajax.responseText);
            if (odgovor.hasOwnProperty('greska')) {                
                alert(odgovor.greska);
            }
        }
        if (ajax.readyState == 4 && ajax.status == 404)
            document.innerHTML = stranica.toString();
    }
    ajax.open("GET", servis, true);
    ajax.send();    
}



function provjeraPredSlanje() {
    provjeraMjestaIOpcine();  

    var ime = document.getElementById("ime");
      var mail = document.getElementById("mail");
      if (!provjeri(ime) || !provjeri(mail) || document.getElementById("poruka").value == '') {
          alert("Slanje nije moguće, provjerite unos!");
          document.getElementsByClassName("porukaOGresci")[0].style.visibility = 'visible';
          return false;
      } 
                
}




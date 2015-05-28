<div id="meni">
    <ul>
        <li><a href="#" onclick="return dajStranicu('pocetna.html')">Početna</a></li>
        <li><a href="#" onclick="return dajStranicu('novosti.php')">Novosti</a></li>
        <li onmouseover="document.getElementById('padajuciMeni').style.visibility = 'visible';" onmouseout="document.getElementById('padajuciMeni').style.visibility = 'hidden';">
            <a href="#" onclick="return dajStranicu('ponuda.html')">Ponuda</a>
            <div id="padajuciMeni" onmouseout="document.getElementById('padajuciMeni').style.visibility = 'hidden';">
                <ul>
                    <li><a href="#" onclick="return dajStranicu('stolice.html')">Stolice</a></li>
                    <li><a href="#" onclick="return dajStranicu('fotelje.html')">Fotelje</a></li>
                    <li><a href="#" onclick="return dajStranicu('Dvosjedi.html')">Dvosjedi</a></li>
                    <li><a href="#" onclick="return dajStranicu('trosjedi.html')">Trosjedi</a></li>
                    <li><a href="#" onclick="return dajStranicu('stolovi.html')">Stolovi</a></li>
                </ul>
            </div>
        </li>
        <li><a href="#" onclick="return dajStranicu('onama.html')">O nama</a></li>
        <li><a href="#" onclick="return dajStranicu('kontakt.php')">Kontakt</a></li>
        <?php
            
            if(!isset($_SESSION['username'])) {
            print '<li onmouseover="prikaziLogin();" onmouseout="sakrijLogin();"> <a href="#">Prijava</a>
                <div id="loginDiv">
                    <script>alert("aasasa"); </script>
                    <form method="post" action="index.php">
                        Username: <input name="username"> <br>
                        Password: <input type="password" name="password"> <br>
                        <a href="#">Zaboravili ste lozinku ?</a> <br>
                        <input type="submit" name="btnSubmit" value="Loguj se">
                    </form>
                </div>
            </li>';
            }else {
                print '<li onmouseover="prikaziLogin();" onmouseout="sakrijLogin();"> <a href="#">Odjava</a>
                <div id="loginDiv">
                    <form method="post" action="index.php">
                        <h4>Logovani korisnik:</h4> <h3>'.$_SESSION['username'].'</h3>
                        <input type="submit" name="btnOdjava" value="Odjava">
                    </form>
                </div>
            </li>';
            }
        ?>

    </ul>
</div>
<a href="#" onclick="return dajStranicu('pocetna.html')"><img src="logo.png" alt="logo.png"></a>
<div id="naslov">

    <h4>Proizvodnja i prodaja raznih vrsta kućnog namještaja</h4>
    <a href="#" onclick="return dajStranicu('pocetna.html')">
        <h1>Agović</h1>
    </a>
</div>
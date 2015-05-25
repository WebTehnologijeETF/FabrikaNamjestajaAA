<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Namještaj Agović</title>
        <link rel="stylesheet" type="text/css" href="stilIndex.css">
        <script src="ucitaj.js"></script>
        <script src="validacionaSkripta.js"></script>
        <script src="ucitavanjeProizvoda.js"></script>
    </head>
    <body>
        <div id="okvir">
            <div id="zaglavlje">

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
                    </ul>
                </div>
                <a href="#" onclick="return dajStranicu('pocetna.html')"><img src="logo.png" alt="logo.png"></a>
                <div id="naslov">

                    <h4>Proizvodnja i prodaja raznih vrsta kućnog namještaja</h4>
                    <a href="#" onclick="return dajStranicu('pocetna.html')">
                        <h1>Agović</h1>
                    </a>
                </div>


            </div>
            <div id="sredina">
                <div id="spisakArtikala">
                    <ul>
                        <li><a href="#" onclick="return dajStranicu('stolice.html')">Stolice</a></li>
                        <li><a href="#" onclick="return dajStranicu('fotelje.html')">Fotelje</a></li>
                        <li><a href="#" onclick="return dajStranicu('Dvosjedi.html')">Dvosjedi</a></li>
                        <li><a href="#" onclick="return dajStranicu('trosjedi.html')">Trosjedi</a></li>
                        <li><a href="#" onclick="return dajStranicu('stolovi.html')">Stolovi</a></li>
                    </ul>
                </div>

                <?php
                    $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
                    $veza->exec("set names utf8");
                    if(isset($_REQUEST["tip"])) {                         
                        $rezultat = $veza->query("select * from proizvod where tip = '".$_REQUEST['tip']."';");
                    
                        if (!$rezultat) {
                          $greska = $veza->errorInfo();
                          print "SQL greška: " . $greska[2];
                          exit();
                        }	
                         echo "<h1>".$_REQUEST['tip']."</h1>";
                         echo "<div id='sviElementi'>";                            
                         foreach($rezultat as $proizvod) {                                                                
                              echo  '<div class="ponudaElement"> <div class="vrstaElementa">';                      
                              echo  '<h3>'.$proizvod['naziv'].'</h3>';
                              echo  '<img class="slikaArtikla" src="'.$proizvod['slika'].'" alt="'.$proizvod["naziv"].'"> </div>';
                              echo  '<div class="opisElementa">  <p>'.$proizvod["opis"].'</p>  </div> <div class="cijena">';
                              echo  '<p class="cijena">Cijena: '.$proizvod['cijena'].' KM </p>';
                              echo  '<a href="#" class="cijena">Pogledaj detalje</a> </div>';                                        
                        }
                        echo "</div>";
                    }
                    
                ?>
            </div>

            <div id="podnozje">

                <div id="partneri">
                    <h3>Partneri</h3>
                    <a target="_blank" href="http://www.dallas.ba/dallas/index.php"><img src="Slike/partneri/dallas.png" alt="Dallass"></a>
                    <a target="_blank" href="http://http://www.maoles.com/"><img src="Slike/partneri/maoles.png" alt="Maoles"></a>
                    <a target="_blank" href="http://http://www.standard-furniture.ba/Naslovna"><img src="Slike/partneri/standard.png" alt="Standard-Furniture"></a>
                    <a target="_blank" href="http://http://www.sinkromo.co.ba/"><img src="Slike/partneri/sincromo.png" alt="Sincromo"></a>
                </div>
                <div id="dno">
                    <div class="informacije">
                        <p><b>Adresa:</b> <br>
                    Ferhatovića 18 <br>
                    Visoko <br>
                    Bosna i Hercegovina<br>
                        </p>
                        <p>
                            <b>Telefon:</b> +387 63 883 329<br>

                            <b>e-mail:</b> obrt.agovic@gmail.com<br>

                            <b>web:</b> www.agovic.ba<br>
                        </p>
                    </div>
                    <p class="faris">
                        <b>Dizajn:</b> Džafić Faris, 2015 - <br>
                        <b>Mail:</b> faris.dzafic@gmail.com <br>
                        <b>Telefon:</b> +387 62 961 960 <br>
                    </p>
                </div>

            </div>
        </div>
    </body>
</html>




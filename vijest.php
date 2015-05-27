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
                <?php
                    //postavka vijesti
                    if(isset($_REQUEST["vijestId"])) {
                        $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
                        $veza->exec("set names utf8");                         
                        $rez = $veza->query("select * from novost where id=".$_REQUEST["vijestId"]);  
                        if (!$rez) {
                            $greska = $veza->errorInfo();
                            print "SQL greška kod dobavljanja vijesti: ". $greska[2];
                            exit();
                        }    
                        $rezultat = NULL;                                                
                        foreach($rez as $value) {                    
                            $rezultat = $value;
                            break;
                        }
                        $broj = $veza->query("select count(*) from komentar where novostId=".$_REQUEST['vijestId'].";");		            
                        if (!$broj) {
                            $greska = $veza->errorInfo();
                            print "SQL greška kod dobavljanja komentara: " . $greska[2];
                            exit();
                        }
                        $brojKomentara = $broj->fetchColumn();
                    
                    }
                ?>
                <div id="novost">
                    <div id="naslovNovost">
                        <h1><?php echo $rezultat['naslov'] ?></h1>
                    </div>
                    <div id="slikaNovost">
                        <img src="<?php echo $rezultat['slika']?>" alt="Slika">
                    </div>
                    <div id="tekstNovost">
                        <p><?php echo $rezultat['tekst']?></p>
                        <small><?php echo $rezultat['datum']?></small>
                    </div>
                    <?php
                        if(isset($_POST["btnSubmit"])) {                                                                        
                            $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
                            $veza->exec("set names utf8");                             
                            $rez = $veza->query("insert into komentar set novostId=".$_REQUEST['vijestId'].", autor='".$_POST['komentarIme']."', mail='".$_POST['komentarMail']."', tekst='".$_POST['komentarTekst']."'");                            
                            if (!$rez) {
                                $greska = $veza->errorInfo();
                                print "SQL greška: ". $greska[2];
                                exit();
                            }         
                        }
                    ?>
                    <div id="ostaviKomentarNovost">
                        <?php
                            
                            echo "<form method='post' action='vijest.php?vijestId=".$_REQUEST['vijestId']."'>";
                        ?>
                        <h3> Ostavi komentar</h3> <br>
                            Ime: <input name="komentarIme"> (opt)
                            E-Mail: <input name="komentarMail"> (opt) <br>
                            Komentar: <textarea class="komentarArea" name="komentarTekst"></textarea> <br>
                        <input class="button" name="btnSubmit" type="submit" value="Pošalji">
                        </form>
                    </div>

                    <?php
                        if($brojKomentara == 0) print "<small class='brojKomentara'>Nema komentara</small>";
                          else { 
                              if($brojKomentara == 1) print "<a class='brojKomentara' href=vijest.php?vijestId=".$_REQUEST['vijestId']."&prikaziKomentare=prikazi>".$brojKomentara." komentar </a>";
                              else print "<a class='brojKomentara' href=vijest.php?vijestId=".$_REQUEST['vijestId']."&prikaziKomentare=prikazi>".$brojKomentara." komentara </a>";
                          }
                        
                        if(isset($_REQUEST["prikaziKomentare"])) {
                             $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
                             $veza->exec("set names utf8");                             
                             $rez = $veza->query("select * from komentar where novostId=".$_REQUEST['vijestId']." order by datum DESC;");                            
                             if (!$rez) {
                                $greska = $veza->errorInfo();
                                print "SQL greška kod prikaza komentara: ". $greska[2];
                                exit();
                             }                             
                        echo "<h3>Svi komentari</h3>";
                            foreach($rez as $rezultat) {
                                echo "<div id='komentariNovost'>";
                                echo   '<div id="naslovKomentara">';
                                echo    "<p>".$rezultat['datum']."</p>";
                                echo    "<p>".$rezultat['autor']."</p>";
                                echo    "<p>".$rezultat['mail']."</p>";
                                echo    "</div>";
                                echo    "<p class='tekstVijesti'>".$rezultat['tekst']."</p>";
                                echo    "</div>";
                            }                           
                        }
                    ?>
                </div>

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


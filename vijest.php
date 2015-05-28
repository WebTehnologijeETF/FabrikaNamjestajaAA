<?php
    // izvršava se nakon slanja komentara (spremanje u bazu)       
       if(isset($_POST["btnSubmit"])) {                                                                        
           $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
           $veza->exec("set names utf8");                             
           $rez = $veza->query("insert into komentar set novostId=".$_REQUEST['vijestId'].", autor='".$_POST['komentarIme']."', mail='".$_POST['komentarMail']."', tekst='".$_POST['komentarTekst']."'");                            
           if (!$rez) {
               $greska = $veza->errorInfo();
               print "SQL greška kod unosa komentara: ". $greska[2];
               exit();
           }         
       }
           //izvršava se nakon što je admin prijavljen i klikne na link za brisanje komentara
       if(isset($_REQUEST['zaObrisat'])) {
           $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
           $veza->exec("set names utf8"); 
           $rez = $veza->query("delete from komentar where id=".$_REQUEST['zaObrisat']);                            
           if (!$rez) {
               $greska = $veza->errorInfo();
               print "SQL greška kod brisanja komentara: ". $greska[2];
               exit();
           }    
       }
    
?>
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
                <script>
 dajDiv('zaglavlje', 'zaglavlje.php')
                </script>
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
                        $rezultat = NULL;          //uzimanje samo jeddne vijesti.                                      
                        foreach($rez as $value) {                    
                            $rezultat = $value;
                            break;
                        }
                    
                        //prebrojavanje komentara
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
                       
                          //dobavaljanje svih komentara i njihov prikaz
                        if(isset($_REQUEST["prikaziKomentare"])) {
                              session_start();
                             $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
                             $veza->exec("set names utf8");                             
                             $rez = $veza->prepare("select * from komentar where novostId=? order by datum DESC;");    
                             $rez->execute(array($_REQUEST['vijestId']));                        
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
                                if(isset($_SESSION['username'])) echo "<a href=vijest.php?zaObrisat=".$rezultat['id']."&vijestId=".$_REQUEST['vijestId'].">Obriši</a>"; 
                                echo    "</div>";
                                echo    "<p class='tekstVijesti'>".$rezultat['tekst']."</p>";
                                echo    "</div>";
                            }                           
                        }
                    ?>
                </div>

            </div>

            <div id="podnozje">
                <script>
 dajDiv('podnozje', 'podnozje.html')
                </script>
            </div>
        </div>
    </body>
</html>


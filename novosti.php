<?php
    if(isset($_REQUEST['zaBrisat'])) {
        $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
        $veza->exec("set names utf8");                             
        $rez = $veza->query("delete from novost where id=".$_REQUEST['zaBrisat']);                            
        if (!$rez) {
        $greska = $veza->errorInfo();
        print "SQL greška kod brisanja novosti: ".$greska[2];
        exit();
        }     
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Novosti - Namještaj Agović</title>
        <link rel="stylesheet" type="text/css" href="stilIndex.css">
        <script src="ucitaj.js"></script>
        <script src="validacionaSkripta.js"></script>
        <script src="ucitavanjeProizvoda.js"></script>
    </head>
    <body>
        <div id="okvir">
            <div id="zaglavlje">
                <script>
                    dajDiv('zaglavlje' ,'zaglavlje.php');
                </script>
            </div>
            <div id="sredina">
                <h1> Novosti </h1>
                <?php
                    session_start();
                    if(isset($_POST['btnSubmit'])) {
                        $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
                        $veza->exec("set names utf8");                             
                        $rez = $veza->query("insert into novost set naslov='".$_POST['naslov']."', tekst='".$_POST['novost']."', slika='".$_POST['slika']."'");                            
                        if (!$rez) {
                        $greska = $veza->errorInfo();
                        print "SQL greška kod unosa novosti: ".$greska[2];
                        exit();
                        }     
                    }          
                    if(isset($_REQUEST['zaUredit']))  {
                        $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
                        $veza->exec("set names utf8");  
                        $rez = $veza->query("select * from novost where id=".$_REQUEST['zaUredit']);                            
                        if (!$rez) {
                        $greska = $veza->errorInfo();
                        print "SQL greška kod unosa novosti: ".$greska[2];
                        exit();
                        }   
                        $rezultat = NULL;
                        foreach($rez as $value) {
                            $rezultat = $value;
                            break;
                        }      
                                        
                    } 
                    if(isset($_POST['btnUredi'])) {
                        $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
                        $veza->exec("set names utf8");  
                        $rez = $veza->query("update novost set naslov='".$_POST['naslov']."', tekst='".$_POST['novost']."', slika='".$_POST['slika']."' where id=".$_POST['vijestId']);                            
                        if (!$rez) {
                        $greska = $veza->errorInfo();
                        print "SQL greška kod uređivanja vijesti: ".$greska[2];
                        exit();
                        }   
                        $rezultat = NULL;
                        foreach($rez as $value) {
                            $rezultat = $value;
                            break;
                        }      
                    }           
                                  
                    if(isset($_SESSION['username'])) {
                    print '<div id="adminNovost">
                        <form method="post" action="novosti.php">
                            <input type="hidden" name="vijestId" value='.$_REQUEST['zaUredit'].'>
                            <table>
                                <tr>
                                    <td>Naslov:</td>
                                    <td><input name="naslov" value='.$rezultat['naslov'].'></td>
                                </tr>
                                <tr>
                                    <td>Slika:
                                    <td><input name="slika" value='.$rezultat['slika'].'></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Tekst Novosti:</td>
                                </tr>
                            </table>
                            <textarea name="novost">'.$rezultat['tekst'].'</textarea>
                            <input class="buttonNovosti" type="reset" value="Obriši sve">';
                        if(!isset($_REQUEST['zaUredit'])) echo ' <input class="buttonNovosti" name="btnSubmit" type="submit" value="Objavi">';
                        else  echo ' <input class="buttonNovosti" name="btnUredi" type="submit" value="Uredi">';
                        print   '</form>  </div>';
                    }
                        $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
                        $veza->exec("set names utf8");                                             
                        $rezultat = $veza->query("select * from novost order by datum DESC;");
                    
                        if (!$rezultat) {
                            $greska = $veza->errorInfo();
                            print "SQL greška: " . $greska[2];
                            exit();
                        }	 
                    
                        echo "<div id='ponuda'>";                            
                        foreach($rezultat as $value) {    
                    
                            echo '<div class="element">';                               
                            echo '<a href="vijest.php?vijestId='.$value["id"].'">';
                            echo '<h2>'.$value["naslov"].'</h2>';
                            echo '<img class="slikaProizvoda" src="'.$value["slika"].'" alt="'.$value["naslov"].'">  </a>  ';                                
                            if(isset($_SESSION['username'])) {
                                 echo "<a href='novosti.php?zaBrisat=".$value['id']."'>Obriši vijest</a>";
                                 echo "<a style='padding-left: 140px;' href='novosti.php?zaUredit=".$value['id']."'>Uredi vijest</a>";
                            }
                            echo "</div>";
                        }
                        echo "</div>";                                        
                ?>
            </div>
            <div id="podnozje">
                <script>
                    dajDiv('podnozje', 'podnozje.html');
                </script>
            </div>
        </div>
    </body>
</html>




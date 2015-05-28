<?php
    
    //nakon klika na dodavanje administratora
    if(isset($_POST['btnDodaj'])) {
        $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
        $veza->exec("set names utf8");        
        if($_POST['korisnickaLozinka1'] != $_POST['korisnickaLozinka2']) {
            echo "<h1 style='color:white; text-align:center;'>Pogrešna lozinka!<h1>";
    
        }else {
            $pass = md5($_POST['korisnickaLozinka1']);
            $rez = $veza->query("insert into korisnik set username='".$_POST['korisnickoIme']."', password='".$pass."', mail='".$_POST['korisnickiMail']."'");
            if (!$rez) {
                $greska = $veza->errorInfo();
                print "SQL greška kod dodavanja admina: ". $greska[2];
                exit();
            }    
        }
    }
    
    //nakon klika na brisanje admina
    if(isset($_REQUEST['obrisi'])) {
         $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
         $veza->exec("set names utf8");
         $rez = $veza->query("delete from korisnik where id=".$_REQUEST['obrisi']);
        if (!$rez) {
            $greska = $veza->errorInfo();
            print "SQL greška kod dobavljanja admina: ". $greska[2];
            exit();
        }    
    }
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Admin panel - Namještaj Agović</title>
        <link rel="stylesheet" type="text/css" href="stilIndex.css">
        <script src="ucitaj.js"></script>
        <script src="validacionaSkripta.js"></script>
        <script src="ucitavanjeProizvoda.js"></script>
    </head>
    <body>
        <div id="okvir">
            <div id="zaglavlje" style="background-color: white;">
                <script>
 dajDiv('zaglavlje', 'zaglavlje.php');
                </script>
            </div>
            <div id="adminPanel">
                <h1>Panel za administratora stranice</h1>
                <form method="post" action="adminpanel.php">
                    <table>
                        <tr>
                            <td colspan="2"><h1>Dodavanje admina</h1></td>
                        </tr>
                        <tr>
                            <td>Korisnicko ime:</td>
                            <td>
                                <input name="korisnickoIme">
                            </td>
                        </tr>
                        <tr>
                            <td>Korisnicka lozinka:</td>
                            <td>
                                <input type="password" name="korisnickaLozinka1">
                            </td>
                        </tr>
                        <tr>
                            <td>Potvrdi korisnicku lozinku:</td>
                            <td>
                                <input type="password" name="korisnickaLozinka2">
                            </td>
                        </tr>
                        <tr>
                            <td>Mail:</td>
                            <td>
                                <input name="korisnickiMail">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input class="buttonNovosti" type="submit" value="Dodaj" name="btnDodaj">
                            </td>
                        </tr>
                    </table>
                </form>
                <h1>Svi administratori</h1>
                <table>
                    <tr>
                        <td>ID</td>
                        <td>Korisničko ime</td>
                        <td>Mail</td>
                        <td>Briši</td>
                        <td>Nova lozinka</td>
                    </tr>
                    <?php
                        //ispisivanje svih administratora u tabelu
                        $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
                        $veza->exec("set names utf8");                       
                        $rez = $veza->query("select * from korisnik");                            
                        if (!$rez) {
                                $greska = $veza->errorInfo();
                                print "SQL greška kod dobavljanja admina: ". $greska[2];
                                exit();
                        }
                        
                        foreach($rez as $value) {                                                                    
                            echo '<tr><td>'.$value['id'].'</td><td>'.$value['username'].'</td><td>'.$value['mail'].'</td><td><a href="adminpanel.php?obrisi='.$value["id"].'">Obriši</a></td><td><a href="adminpanel.php?novaLozinka='.$value['id'].'">Nova lozinka</a></td></tr>';
                        }
                        
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>

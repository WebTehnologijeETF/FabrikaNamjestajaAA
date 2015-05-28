<?php
    //$veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
    //$veza->exec("set names utf8");
    //$pass = md5('password');
    //$rez = $veza->query("insert into admin set username='fdzafic', password='".$pass."', mail='fdzafic1@etf.unasa.ba'");
    //if (!$rez) {
    //                        $greska = $veza->errorInfo();
    //                        print "SQL greška kod dobavljanja admina: ". $greska[2];
    //                        exit();
    //                }    
    
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
        <div id="zagljavlje">
            <script></script>
        </div>
        <div id="adminPanel">
            <h1>Panel za administratora stranice</h1>
            <table>
                <tr>
                    <td>ID</td>
                    <td>Korisničko ime</td>
                    <td>Lozinka</td>
                    <td>Uredi</td>
                    <td>Briši</td>
                    <td>Nova lozinka</td>
                </tr>
                <?php
                    $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
                    $veza->exec("set names utf8");   
                    
                    $rez = $veza->query("select * from korisnik");    
                    echo "xxxx";               
                    if (!$rez) {
                            $greska = $veza->errorInfo();
                            print "SQL greška kod dobavljanja admina: ". $greska[2];
                            exit();
                    }
                    
                    foreach($rez as $value) {   
                        echo "xxxx";                     
                        echo '<tr><td>'.$value['id'].'</td><td>'.$value['username'].'</td><td>'.$value['mail'].'</td><td><a href="adminpanel.php?edit='.$value['id'].'>Uredi</a></td><td><a href="adminpanel.php?obrisi='.$value['id'].'">Obriši</a></td><td><a href="adminpanel.php?novaLozinka='.$value['id'].'>Nova lozinka</a></td></tr>';
                    }
                    
                ?>
            </table>
        </div>
    </body>
</html>

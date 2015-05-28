<?php    
    if(isset($_POST['btnSubmit'])) {
        $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
        $veza->exec("set names utf8"); 
    
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $pass = md5($pass);
        
        $upit = $veza­->query("select * from admin where username=".$user." and password=".$pass.";"); 
        //$upit->bindValue(":username", $user, PDO::PARAM_STR);  
        //$upit->bindValue(":password", $pass, PDO::PARAM_STR);     
        //$upit­->execute(); 
        echo "xxxx"; 
        if (!$upit) {
            $greska = $veza->errorInfo();
            print "SQL greška kod dobavljanja admina: ". $greska[2];
            exit();
        }
        $broj = mysql_num_rows($upit);
        if($broj == 1) {
            session_start();            
            $rezultat = NULL;
            foreach($upit as $value) {
                $rezultat = $value;
                break;
            }
            $_SESSION['username'] = $rezultat['username'];
            $_SESSION['mail'] = $rezultat['mail'];
            $_SESSION['adminId'] = $rezultat['id'];
        }    
    }
    if(isset($_POST['btnOdjava'])) {
        session_unset();
        session_destroy();
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
                <script> dajDiv('zaglavlje', 'zaglavlje.php')</script>                       
            </div>
            <div id="sredina">
                <script>
                    dajStranicu("pocetna.html");
                </script>
            </div>

            <div id="podnozje">
                <script> dajDiv('podnozje', 'podnozje.html')</script>         
            </div>
        </div>
    </body>
</html>




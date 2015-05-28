<div id="sredina">
    <h1>Kontakt</h1>
    
    <div id="kontakt">
        <?php
            
            if(isset($_GET["slanje"])) {   
                session_start();                         
                echo "<div id = 'predSlanje'> <form action='mail.php' method='POST'> <h3>Provjerite da li ste ispravno popunili kontakt formu </h3> <br>";
                echo "<p><i>Ime i prezime: </i></p> <p id='imeNovo'> ".$_GET['ime']."</p> <br> <p><i>Mjesto: </i></p> <p> ".$_GET['mjesto']."</p> <br>";
                echo "<p><i>Općina: </i></p> <p>".$_GET['opcina']."</p> <br> <p><i>E-Mail: </i></p> <p> ".$_GET['mail']."</p> <br>";
                echo "<p><i>Naslov: </i></p> <p> ".$_GET['naslov']."</p> <br> <p><i>Poruka: </i></p> <p>".$_GET['poruka']."</p> <br>";
                echo "<p>Da li ste sigurni da želite poslati ove podatke?</p> <input type='submit' value='Siguran sam' name='salji'> </div> "; 
                echo "<h3>Ako ste pogrešno popunili formu, možete ispod prepraviti unesene podatke </h3>";       
                $_SESSION["mailIme"] = $_GET["ime"];
                $_SESSION["mailMjesto"] = $_GET["mjesto"];
                $_SESSION["mailOpcina"] = $_GET["opcina"];
                $_SESSION["mailMail"] = $_GET["mail"];
                $_SESSION["mailNaslov"] = $_GET["naslov"];
                $_SESSION["mailPoruka"] = $_GET["poruka"];                                                                                    
            }
            
            if(isset($_REQUEST["salji"])) {
                echo "<h2>Zahvaljujemo se što ste nas kontaktirali !</h2>";
                $to = "fdzafic1@etf.unsa.ba";
                $subject = $SESSION["mailNaslov"];
                $message = $SESSION["mailIme"]."\n".$SESSION["mailMjesto"]."\n".$SESSION["mailOpcina"]."\n \n \n".$SESSION["mailPoruka"];
                mail($to, $subject, $message); 
                session_destroy();
            }   
            
        ?>


        <h3>Kontaktirajte nas slanjem poruke, a mi ćemo vam odgovoriti na mail</h3>
        <p>(Polja sa * su obavezna!)</p>
        <p class="porukaOGresci">Slanje nije moguće. Neke kontakt informacije niste unijeli ili nisu korektne!</p>
        <form action="mail.php" id="kontaktForma" method="GET" name="kontaktForma" onsubmit="return provjeraPredSlanje()">
            <table>
                <tr>
                    <td>*Ime i prezime:</td>
                    <td><input class="podaci" value="<?php
		                                if (isset($_REQUEST['ime']))
                                        print $_REQUEST['ime'];
                                        ?>" id="ime" name="ime" onblur="provjeri(this)"></td>
                    <td><img id="greskaIme" src="Slike/x.png" alt="X" title="Morate unijeti ime i prezime!"></td>
                </tr>
                <tr>
                    <td>Mjesto:</td>
                    <td><input value="<?php
		                                if (isset($_REQUEST['mjesto']))
                                        print $_REQUEST['mjesto'];
                                        ?>" class="podaci" id="mjesto" name="mjesto"></td>
                    <td><img id="greskaMjesto" src="Slike/x.png" alt="X" title="Mjesto nije korektno!"></td>
                </tr>
                <tr>
                    <td>Općina:</td>
                    <td><input value="<?php
		                                if (isset($_REQUEST['opcina']))
                                        print $_REQUEST['opcina'];
                                        ?>" class="podaci" id="opcina" name="opcina"></td>
                    <td><img id="greskaOpcina" src="Slike/x.png" alt="X" title="Opcina nije korektna!"></td>
                </tr>
                <tr>
                    <td>*E mail:</td>
                    <td><input value="<?php
		                                if (isset($_REQUEST['mail']))
                                        print $_REQUEST['mail'];
                                        ?>" class="podaci" id="mail" name="mail" onblur="provjeri(this)"></td>
                    <td><img id="greskaMail" src="Slike/x.png" alt="X" title="Morate unijeti svoju E-Mail adresu!"></td>
                </tr>
                <tr>
                    <td>Naslov:</td>
                    <td><input value="<?php
		                                if (isset($_REQUEST['naslov']))
                                        print $_REQUEST['naslov'];
                                        ?>" class="podaci" id="naslov" name="naslov"></td>
                </tr>
            </table>
            <h4 class="tekstPoruka">*Poruka:</h4>
            <textarea id="poruka" name="poruka"><?php
                if (isset($_REQUEST['poruka']))
                print $_REQUEST['poruka'];
                ?></textarea>

            <input class="button" name="slanje" type="submit" value="Pošalji">
        </form>
    </div>

</div>

          
<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Namještaj Agović</title>
        <link rel="stylesheet" type="text/css" href="stilIndex.css">
        <script src="ucitaj.js"></script>
        <script src="validacionaSkripta.js"></script>
        <script src="ucitavanjeProizvoda.js"></script>
        <script src="skripte/novost.js"></script>
    </head>
    <body>
        <div id="okvir">
            <div id="zaglavlje">
                <script>
                    dajDiv('zaglavlje', 'zaglavlje.php')
                </script>
            </div>
            <div id="sredina">
                

                <h1> Novosti </h1>
                <div id="ponuda">
                    <?php                        
                        if(isset($_SESSION['username'])) {
                            print '<div id="adminNovost">                        
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
                            <textarea name="novost">'.$rezultat['tekst'].'</textarea>';
                             print ' <input class="buttonNovosti" name="btnSubmit" onclick="dodajNovost(null)" type="button" value="Objavi">';
                           
                            print ' </div>';
                        }
                    ?>
                    <script>
                        dobaviNovosti(<?php if(isset($_SESSION['username'])) echo "true"; else echo "false";?>);
                    </script>
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
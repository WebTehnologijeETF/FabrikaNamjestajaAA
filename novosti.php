<div id="sredina">
    <h1> Novosti </h1>
    <?php        
        class Vijest { 
            function Vijest() {
                $this->datum;
                $this->naslov;
                $this->link;
                $this->tekst;
                $this->detalji;
            }       
        }
        
        $sveVijesti = array();
        
       foreach(scandir("vijesti", 1) as $key => $filename) {
            if ($filename == '.' || $filename == '..') { 
            continue; 
            } 
            $dat = fopen("vijesti/".$filename, "r");            
            $vij = new Vijest();            
            $vij->datum = fgets($dat);        
            $vij->naslov = fgets($dat);
            $vij->link = fgets($dat);
            $oznaka = "--";
            while(($temp = fgets($dat)) !== false) { 
                if(strcmp((string)$temp, $oznaka) == 0) { echo "<h1>".$temp."</h1>"; break 2; }
                $temp2 = $vij->tekst;                                              
                $vij->tekst = $temp2." ".$temp;
            }        
            while(($temp = fgets($dat)) !== false) {
                $temp2 = $vij->detalji;                                              
                $vij->detalji = $temp2." ".$temp;
            }        
            array_push($sveVijesti, $vij);
            fclose($dat);  
        }          
           
        function cmp($a, $b) {
            return strtotime($a->datum) - strtotime($b->datum);
        }
        
        usort($sveVijesti, "cmp");
        
        foreach($sveVijesti as $key => $value) {
        echo "<div class='ponudaElement'>";
        
        echo '<div class="vrstaElementa">';
        echo  '<h3>"'.$value->naslov.'"</h3>';
        echo   '<img class="slikaArtikla" src="'.$value->link.'" alt="'.$value->naslov.'"></div>';
        echo '<div class="opisElementa">';
        echo  '<p>'.$value->tekst.'</p></div>';
        
        echo '<div class="cijena">';
        if($value->detalji != null)
        echo '<a href="#" class="cijena">Pogledaj detalje</a>';
        echo  '<p>'.$value->datum.'</p> </div> </div>';                                   
        }        
    ?>

  <??>
    
</div>
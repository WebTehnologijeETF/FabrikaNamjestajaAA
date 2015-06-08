<?php
    function zag() {
        header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
        header('Content-Type: text/html');
        header('Access-Control-Allow-Origin: *');
    }
    
    function rest_get($request, $data) {        
        if($data["sta"] == "dobaviSve") {
            $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
            $veza->exec("set names utf8");                                             
            $rezultat = $veza->query("select * from novost order by datum DESC;");
    
            if (!$rezultat) {
                $greska = $veza->errorInfo();
                print "SQL greška: " . $greska[2];
                //exit();
            }	         
            print json_encode($rezultat->fetchAll());      
        } 
    }
    
    function rest_post($request, $data) {  
        //$data = json_decode($data["novost"], true);       
        $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
        $veza->exec("set names utf8");                                           
        $rezultat = $veza->prepare("insert into novost(naslov, tekst, slika) values(?,?,?)");
        $rezultat->execute(array($data["naslov"],$data["tekst"],$data["slika"]));        
        if (!$rezultat) {
            $greska = $veza->errorInfo();
            print json_encode(array("OK"=>"NO"));            
        } else print json_encode(array("OK"=>"OK")); //json_encode(array("OK" => $data["naslov"].$data["tekst"].$data["slika"]));//
    }
    
    function rest_delete($request, $data) {
        $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
        $veza->exec("set names utf8");                                           
        $rezultat = $veza->prepare("delete from novost where id = ?");
        $rezultat->execute(array($data["id"]));        
        if (!$rezultat) {
            $greska = $veza->errorInfo();
            print json_encode(array("OK"=>"NO"));            
        } else print json_encode(array("OK"=>"OK")); 
    }

    function rest_put($request, $data) { 
        $veza = new PDO("mysql:dbname=agovicdb;host=localhost;charset=utf8", "agovicuser", "*agovicpass#");
        $veza->exec("set names utf8");                                           
        $rezultat = $veza->prepare("update novost set naslov = ?, slika = ?, tekst = ? where id= ?");
        $rezultat->execute(array($data["naslov"], $data["slika"], $data["tekst"], $data["id"]));        
        if (!$rezultat) {
            $greska = $veza->errorInfo();
            print json_encode(array("OK"=>"NO"));            
        } else print json_encode(array("OK"=>"OK")); 
    }
    function rest_error($request) { }
    
    $method  = $_SERVER['REQUEST_METHOD'];
    $request = $_SERVER['REQUEST_URI'];    

    switch($method) { 
        case 'PUT':
            parse_str(file_get_contents('php://input'), $put_vars);
            zag(); $data = $put_vars; rest_put($request, $data); break;
        case 'POST':
            zag(); $data = $_POST; rest_post($request, $data); break;
        case 'GET':
            zag(); $data = $_GET; rest_get($request, $data); break;
        case 'DELETE':
            zag(); $data = $_REQUEST; rest_delete($request, $data); break;
        default:
            header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
            rest_error($request); break;
    }
?>
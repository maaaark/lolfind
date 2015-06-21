<?php

class FIServer {
    public static function send($data){
        $data  = trim($data);
        $local = "http://localhost/";
        $head  = "GET / HTTP/1.1"."\r\n".
                 "Upgrade: WebSocket"."\r\n".
                 "Connection: Upgrade"."\r\n".
                 "Origin: $local"."\r\n".
                 "Host: ".Config::get('fi_server.host')."\r\n".
                 "Content-Length: ".strlen($data)."\r\n"."\r\n";
            
        //WebSocket handshake
        $sock = fsockopen(Config::get('fi_server.host'), Config::get('fi_server.port'), $errno, $errstr, 2);
        fwrite($sock, $head) or die('error:'.$errno.':'.$errstr);
        $headers = fread($sock, 2000);
        
        // Daten senden
        fwrite($sock, $data) or die('error:'.$errno.':'.$errstr);
        
        //receives the data included in the websocket package "\x00DATA\xff"
        $wsdata = fread($sock, 2000);
        fclose($sock);
        return true;
        //echo Config::get('fi_server.host');
    }
}
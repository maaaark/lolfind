<?php

class FIServer {
    public static function send($data){
        $host = Config::get('fi_server.host');  //where is the websocket server
        $port = Config::get('fi_server.port');
        $local = "http://".Config::get('fi_server.host');  //url where this script run

        $head = "GET / HTTP/1.1"."\r\n".
                "Upgrade: WebSocket"."\r\n".
                "Connection: Upgrade"."\r\n".
                "Origin: $local"."\r\n".
                "Host: $host"."\r\n".
                "Sec-WebSocket-Version: 13"."\r\n".
                "Sec-WebSocket-Key: asdasdaas76da7sd6asd6as7d"."\r\n".
                "Content-Length: ".strlen($data)."\r\n"."\r\n";
        //WebSocket handshake
        $sock = fsockopen($host, $port, $errno, $errstr, 2);
        fwrite($sock, $head ) or die('error:'.$errno.':'.$errstr);
        $headers = fread($sock, 2000);
        fwrite($sock, FIServer::hybi10Encode($data)) or die('error:'.$errno.':'.$errstr);
        fclose($sock);
    }

    public static function send_width_answer($data){
        $host = Config::get('fi_server.host');  //where is the websocket server
        $port = Config::get('fi_server.port');
        $local = "http://".Config::get('fi_server.host');  //url where this script run

        $head = "GET / HTTP/1.1"."\r\n".
                "Upgrade: WebSocket"."\r\n".
                "Connection: Upgrade"."\r\n".
                "Origin: $local"."\r\n".
                "Host: $host"."\r\n".
                "Sec-WebSocket-Version: 13"."\r\n".
                "Sec-WebSocket-Key: asdasdaas76da7sd6asd6as7d"."\r\n".
                "Content-Length: ".strlen($data)."\r\n"."\r\n";
        //WebSocket handshake
        $sock = fsockopen($host, $port, $errno, $errstr, 2);
        fwrite($sock, $head ) or die('error:'.$errno.':'.$errstr);
        $headers = fread($sock, 2000);
        fwrite($sock, FIServer::hybi10Encode($data)) or die('error:'.$errno.':'.$errstr);
        
        $out = "";
        while ($line = fgets($sock)) {
            $out .= $line;
            $line = preg_split('/\s+/', $line, 0, PREG_SPLIT_NO_EMPTY);
            $code = $line[0];
            if (strtoupper($code) == 'C01') {
                break;
            }
        }
        fclose($sock);
        return $out;
    }

    public static function add_notification($user, $type, $value1, $value2 = false, $value3 = false){
        $array = array();
        $array["user"]         = $user;
        $array["network_page"] = "teamranked.com";
        $array["type"]         = $type;
        $array["value1"]       = $value1;
        $array["value2"]       = $value2;
        $array["value3"]       = $value3;
        FIServer::send(json_encode(array("type" => "notification", "message" => $array)));
    }


    public static function hybi10Decode($data){
        $bytes = $data;
        $dataLength = '';
        $mask = '';
        $coded_data = '';
        $decodedData = '';
        $secondByte = sprintf('%08b', ord($bytes[1]));
        $masked = ($secondByte[0] == '1') ? true : false;
        $dataLength = ($masked === true) ? ord($bytes[1]) & 127 : ord($bytes[1]);

        if($masked === true){
            if($dataLength === 126){
               $mask = substr($bytes, 4, 4);
               $coded_data = substr($bytes, 8);
            } elseif($dataLength === 127){
                $mask = substr($bytes, 10, 4);
                $coded_data = substr($bytes, 14);
            } else {
                $mask = substr($bytes, 2, 4);       
                $coded_data = substr($bytes, 6);        
            }   
            for($i = 0; $i < strlen($coded_data); $i++){       
                $decodedData .= $coded_data[$i] ^ $mask[$i % 4];
            }
        } else {
            if($dataLength === 126){          
               $decodedData = substr($bytes, 4);
            } elseif($dataLength === 127){           
                $decodedData = substr($bytes, 10);
            } else {               
                $decodedData = substr($bytes, 2);       
            }       
        }   

        return $decodedData;
    }


    public static function hybi10Encode($payload, $type = 'text', $masked = true) {
        $frameHead = array();
        $frame = '';
        $payloadLength = strlen($payload);

        switch ($type) {
            case 'text':
                // first byte indicates FIN, Text-Frame (10000001):
                $frameHead[0] = 129;
                break;

            case 'close':
                // first byte indicates FIN, Close Frame(10001000):
                $frameHead[0] = 136;
                break;

            case 'ping':
                // first byte indicates FIN, Ping frame (10001001):
                $frameHead[0] = 137;
                break;

            case 'pong':
                // first byte indicates FIN, Pong frame (10001010):
                $frameHead[0] = 138;
                break;
        }

        // set mask and payload length (using 1, 3 or 9 bytes)
        if($payloadLength > 65535){
            $payloadLengthBin = str_split(sprintf('%064b', $payloadLength), 8);
            $frameHead[1] = ($masked === true) ? 255 : 127;
            for($i = 0; $i < 8; $i++){
                $frameHead[$i + 2] = bindec($payloadLengthBin[$i]);
            }

            // most significant bit MUST be 0 (close connection if frame too big)
            if($frameHead[2] > 127) {
                $this->close(1004);
                return false;
            }
        } elseif($payloadLength > 125){
            $payloadLengthBin = str_split(sprintf('%016b', $payloadLength), 8);
            $frameHead[1] = ($masked === true) ? 254 : 126;
            $frameHead[2] = bindec($payloadLengthBin[0]);
            $frameHead[3] = bindec($payloadLengthBin[1]);
        } else {
            $frameHead[1] = ($masked === true) ? $payloadLength + 128 : $payloadLength;
        }

        // convert frame-head to string:
        foreach(array_keys($frameHead) as $i){
            $frameHead[$i] = chr($frameHead[$i]);
        }

        if($masked === true){
            // generate a random mask:
            $mask = array();
            for ($i = 0; $i < 4; $i++) {
                $mask[$i] = chr(rand(0, 255));
            }

            $frameHead = array_merge($frameHead, $mask);
        }
        $frame = implode('', $frameHead);
        // append payload to frame:
        for($i = 0; $i < $payloadLength; $i++){
            $frame .= ($masked === true) ? $payload[$i] ^ $mask[$i % 4] : $payload[$i];
        }

        return $frame;
    }

    public static function get_auth_login_code(){
        if(Auth::check()){
            $data = array(
                "uID" => Auth::user()->id,
            );
            return FIServer::encrypt(json_encode($data), "fi_server_secret_key123");
        }
        return "";
    }

    public static function decrypt_auth_login_code($code){
        return FIServer::decrypt($code, "fi_server_secret_key123");
    }

    public static function decrypt($string, $key) {
        $result = '';
        $string = base64_decode($string);
        for($i=0; $i<strlen($string); $i++) {
            $char       = substr($string, $i, 1);
            $keychar    = substr($key, ($i % strlen($key))-1, 1);
            $char       = chr(ord($char)-ord($keychar));
            $result    .=$char;
        }
        return $result;
    }

    public static function encrypt($string, $key) {
        $result = '';
        for($i=0; $i<strlen($string); $i++) {
            $char       = substr($string, $i, 1);
            $keychar    = substr($key, ($i % strlen($key))-1, 1);
            $char       = chr(ord($char)+ord($keychar));
            $result    .=$char;
        }
        return base64_encode($result);
    }
}
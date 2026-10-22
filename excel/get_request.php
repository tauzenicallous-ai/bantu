<?php

class get_request  {

    var $response;


    function __construct($url) {
        $this->url = $url;


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, false);

        $response_r = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {$this->response= "cURL Error #:" . $err;}
        else {$this->response= $response_r;}

    }

}



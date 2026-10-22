<?php

class post_request  {

    var $response;


    function __construct($url,$pay_load) {
        $this->url = $url;
        $this->pay_load=$pay_load;

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->pay_load));
        $response_r = curl_exec($ch);
        curl_close($ch);


       $this->response= $response_r;


    }

}


?>





<?php

    function get_user_info($code) {
        $app_id='18cdf1a39d601cd710a7ff7f0f0f3264';
        $app_secret='1dd6013f47ab1406bcec3d9256dfb81b';

        $postdata = http_build_query(
            array(
                'code' => $code,
                'app_id' => $app_id,
                'app_secret' => $app_secret
            )
        );

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );

        $url = 'https://clef.io/api/v1/authorize';

        // send clef information to clef for authorization and receive OAuth token
        $context  = stream_context_create($opts);
        $response = json_decode(file_get_contents($url, false, $context), true);

        if($response['success']) {
            $access_token = $response['access_token']; }
        else
            echo $response['error'];

        $opts = array('http' =>
            array(
                'method'  => 'GET'
            )
        );

        // get clef info from clef based on OAuth token
        $base_url = 'https://clef.io/api/v1/info';
        $query_string = '?access_token='.$access_token;
        $url = $base_url.$query_string;

        $context  = stream_context_create($opts);
        $response = json_decode(file_get_contents($url, false, $context), true);

        if($response['success'])
            $user_info = $response['info'];
            // {
            //   info: {
            //     id: '12345',
            //     first_name: 'Jesse',
            //     last_name: 'Pollak',
            //     phone_number: '1234567890',
            //     email: 'jesse@clef.io'
            //   },
            //   success: true
            // }
        else
            echo $response['error'];

        return $user_info;
    }
?>
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Helpdesk_model extends CI_Model{
    
    public function authenticate($credentials)
    {
        

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://clockworks.ca/support/helpdesk/api/authorization",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "authorization: Basic ".$credentials,
            "cache-control: no-cache"
          ),
        ));

        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        curl_close($curl);
        
        if($response)
        {
            if($response->CompanyId == 1)
            {

                $response->AuthID = rand();

                return $response;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        
    }
    
}
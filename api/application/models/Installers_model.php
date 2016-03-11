<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Installers_model extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
    }
    
    private $secretKey = 'Techno!@';
    
    public function generateLink($product,$file)
    {
        //http://localhost:8080/install/#/download/x/x
        
        // base64 of container blob and date
        $date = date('d-m-Y', strtotime("+1 week"));
        $base64 = base64_encode($product."|".$file."|".$date);
        
        // hash
        
        $hash = hash_hmac('SHA256', $base64, $this->secretKey);
        
        return 'https://clockworks.ca/install/#/download/'.$base64.'/'.$hash;
    }
    
    public function getInstallers($product)
    {
        $files = array();

        $dir = "..\..\..\installers\stable\\".$product;
        
        
            $sniff = scandir($dir);

            $i = 0;

            foreach($sniff as $file){
                if(strlen($file) > 2){
                        $files[$i]['name'] = $file;
                        $files[$i]['url'] = $this->generateLink($product,$file);
                    $i = $i+1;
                }
            }
        
        return $files;
    }
    
    public function uploadFile($filename, $destination)
    {
        move_uploaded_file($filename,$destination);
    }

}
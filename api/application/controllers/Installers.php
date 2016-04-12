<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Installers extends REST_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Installers_model');
    }
    
    // Get a list of all installers for a certain category
    public function index_get()
    {
        $product = $this->get('product');
        
        $files = $this->Installers_model->getInstallers($product);
        
        $this->response($files, 200);
    }
    
    public function index_post()
    {
        
        if(!empty($_FILES))
        {
            $tempPath = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];
            
            $destination = "..\..\..\installers\stable\\$fileName";
//            $this->Installers_model->uploadFile($fileName,$destination);
            
            if(move_uploaded_file($tempPath, $destination))
            {
                $this->response('success', 200);
            }
            else
            {
                $this->response('fail', 404);
            }
        }
    }
    
    public function checkLink_get()
    {
        // Store get variables
        
        $nameAndDate = $this->get('containerblobdate');
        $hash = $this->get('hash');
        
        // name and date extracted from base64 var
        $tmp = base64_decode($nameAndDate);
        $nameAndDateSplit = explode('|', $tmp);
        
        // Check hash
        
        $hashCompare = hash_hmac('SHA256', $nameAndDate, 'Techno!@');
        
        if($hashCompare != $hash){
            $this->response(array('message'=>'Link is invalid. Please contact TPRO for a new link.'), 404);
        }
        
        // Check Date
        
        $clientDate = strtotime(date('d-m-Y', strtotime($nameAndDateSplit[2])));
        $clientDateFormatted = date('l F j, Y', strtotime($nameAndDateSplit[2]));
        
        $now = strtotime(date('d-m-Y'));
        
        if($clientDate < $now){
            $this->response(array('message'=>'Link has expired. Please contact TPRO for a new link'), 404);
        }
        
        $link = $this->Installers_model->generateLink($nameAndDateSplit[0],$nameAndDateSplit[1]);
        
        $blobLink = 'http://localhost:8080/install/api/index.php/installers/download/';
        
        $response = array('name'=>$nameAndDateSplit[1],'link'=>$link, 'date'=>$clientDateFormatted,'url'=>$blobLink);
        
        $this->response($response,200);
    }
    
    public function download_get()
    {
        // Store get variables
        
        $nameAndDate = $this->get('containerblobdate');
        $hash = $this->get('hash');
        
        // name and date extracted from base64 var
        $tmp = base64_decode($nameAndDate);
        $nameAndDateSplit = explode('|', $tmp);
        
        // Check hash
        
        $hashCompare = hash_hmac('SHA256', $nameAndDate, 'Techno!@');
        
        if($hashCompare != $hash){
            $this->response(array('message'=>'Link is invalid. Please contact TPRO for a new link.'), 404);
        }
        
        // Check Date
        
        $clientDate = strtotime(date('d-m-Y', strtotime($nameAndDateSplit[2])));
        $clientDateFormatted = date('l F j, Y', strtotime($nameAndDateSplit[2]));
        
        $now = strtotime(date('d-m-Y'));
        
        if($clientDate < $now){
            $this->response(array('message'=>'Link has expired. Please contact TPRO for a new link .. '.$clientDate.' '.$now), 404);
        }
        
        if(filesize("..\..\..\installers\stable\\".$nameAndDateSplit[0]."\\".$nameAndDateSplit[1])){
           header("Content-Length:". filesize("..\..\..\installers\stable\\".$nameAndDateSplit[0]."\\".$nameAndDateSplit[1]));
        }
        
        header("Content-Disposition: attachment; filename=\"$nameAndDateSplit[1]\"");
        header('Content-Description: File Transfer');
        header('Content-type: application/x-ole-storage');
        header('application/force-download');
        header('Content-Transfer-Encoding: binary');
        
        
        readfile("..\..\..\installers\stable\\".$nameAndDateSplit[0]."\\".$nameAndDateSplit[1]);

    }
    
}
?>
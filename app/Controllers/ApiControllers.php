<?php

namespace App\Controllers;

class ApiControllers extends BaseController
{
    public function index()
    {   
        $data = array('title'=>'Shling Market API Version 1.0',
         'message' => 'Welcome To Our API Version 1.0');
        
        header('Content-Type: application/json');
        return $this->response->setJSON($data);
    }

    public function products()
    {
        $data = array('title'=>'Shling Market API Version 1.0',
         'message' => 'Welcome To Our API Version 1.0');
        
        header('Content-Type: application/json');
        return $this->response->setJSON($data);
    }

    public function add_products()
    {
        $data = array('title'=>'Shling Market API Version 1.0',
         'message' => 'Welcome To Our API Version 1.0');
        
        header('Content-Type: application/json');
        return $this->response->setJSON($data);
    }
}

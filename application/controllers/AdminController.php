<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AdminController extends MyController {
     public function __construct() {
        parent::__construct();
        
        $ArrSession = $this->sessionData();
        
        if(!$ArrSession || $ArrSession['role'] === USER){
                 redirect('index', 'main');
        }
    }

    public function index(){
        $this->load->view('admin/index');
    }
    
}
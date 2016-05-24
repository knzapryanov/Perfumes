<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MyController extends CI_Controller
{
    public function sessionData() {
        $hasSessionId = $this->session->userdata('id');
        $role = (int)$this->session->userdata('role');
        
        if(is_null($hasSessionId)) {
            return false;
        }
        
        return array(
            'id' => $hasSessionId,
            'role' => $role
        );
    }
    
    public function currentPage($page, $errorArr = '') {
        $this->load->view('header');
        $this->load->view($page, $errorArr);
        $this->load->view('footer');
    }
    
}
    
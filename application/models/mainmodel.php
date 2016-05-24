<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MainModel extends CI_Model {
    public function validationUser(){
       $data = array(
         'email' => $this->input->post('email'),
         'password' => $this->input->post('password')
       );
  
       $query = $this
               ->db
               ->where($data)
               ->get('users')->result();
       
       $count = count($query);
       if($count > 0){
           
           return $query;
       }
       else
       {
           return false;
       }
   }
   
   public function insertUserSuccess() {
       unset($_POST['password_confirm']);
        
       if(isset($_POST['is_newsletter'])) {
          $_POST['is_newsletter'] = true; 
       }
       else {
           $_POST['is_newsletter'] = false; 
       }
       
       $_POST['role'] = USER;
       // default user role!
       
       $isSuccess = $this->db->insert('users', $_POST);
       
       if($isSuccess) {
           return true;
       }
       
       return false;
   }
   
   public function checkEmailExist() {
      $row = $this->db->where('email', $_POST['email'])->get('users');
      if($row->num_rows() > 0) {
          return true;
      }
      
      return false;
   }
}
    
    
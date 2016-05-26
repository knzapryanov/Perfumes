<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MyController {
    public function index(){
        $this->currentPage('index');
    }
         
    function generateEncryptStr(){
    $str = md5(md5(time()));
    
    return $str;
    
    }
    
    function permission() {
        $is_empty = $this->mainModel->validationUser();

        if($is_empty !== false){
            $sessionData = array(
                    'id' => $is_empty[0]->id,
                    'first_name' => $is_empty[0]->first_name,
                    'last_name' => $is_empty[0]->last_name,
                    'fullName' => $is_empty[0]->first_name.' '.$is_empty[0]->last_name,
                    'email' => $is_empty[0]->email,
                    'role' => $is_empty[0]->role,
                    'password' => $is_empty[0]->password,
                );            
                
                // user found
                $this->session->set_userdata($sessionData);

                if((int)$is_empty[0]->role === ADMIN){
                    redirect('admin');
                }
                if((int)$is_empty[0]->role === USER){
                    redirect('index');
                }
        }   
        else{
            $this->session->set_flashdata('error','Email or Password not match!');
            redirect('login');
        }
    }
    
    public function logout(){
             $this->session->sess_destroy();
	     redirect('');
    }

    public function login(){
        $this->currentPage('login');
    }
    
    public function register(){
        $this->currentPage('register');
    }
    
    public function registerUser(){
        date_default_timezone_set('Europe/Sofia');
        
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');

        $this->form_validation->set_rules('first_name', 'Username', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Lastname', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password_confirm]',
                array('required' => 'You must provide a %s.')
        );
        
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        
        $this->form_validation->set_message('is_unique', 'Email already exists!');
                
        if ($this->form_validation->run() == FALSE) {
            $this->currentPage('register');
        }
        else {
            if($this->mainModel->insertUserSuccess()) {
                 $data['successMessage'] = '<div class="success">Successfully registered!</div>';
                 $this->currentPage('login', $data);
            }
            $data['error'] = 'Database error occurred, resend!';
            $this->currentPage('register', $data);
           
        }
    }
    
    public function forgotPassword(){
        $this->currentPage('forgot_password');
    }

    public function sendPasswordChangeEmail() {

        if(!$this->mainModel->checkEmailExist()) {
            $data['message'] = 'This email do not exist in our database!!!';
            $this->currentPage('forgot_password', $data) ;
        }

        $this->load->library('email');
        $this->email->from('peturhristozovps@gmail.com', 'Perfumes.com');
        $this->email->to($this->input->post('email'));

        // generate token
        $_SESSION['token'] = $this->generateEncryptStr();
        $userEmail = $this->input->post('email');
        $userId = $this->mainModel->getUserIdByEmail($userEmail);
        
        $link = "Follow the link to change your password in Perfumes.com<br />";
        $link .= "http://localhost/Perfumes/changePasswordAccess?id=".$userId;
        $link .= "&token=".$_SESSION['token'];
        
        $this->email->message($link);
        $this->email->subject('Perfumes.com password change');
        $send = $this->email->send();
        
        if($send) {
            $data['message'] = 'Please check your email address and follow the instructions';
            
        }
        else {
            $data['message'] = 'Error, Please try again! ';
        }
        $this->currentPage('forgot_password', $data) ;
    }

    public function changePasswordAccess() {
        if(isset($_GET['token']) && $_GET['token'] === $_SESSION['token']){
            $_SESSION['userId'] = $_GET['id'];
            $this->currentPage('change_password');
        }
        elseif(isset($_SESSION['userId'])){
            // continue without redirect. Allow authenticated(with token) user to visit changePassword page multiple times
            $this->currentPage('change_password');
        }
        else{
            redirect('');
        }
    }

    public function changePassword() {

        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');

        $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password_confirm]',
            array('required' => 'You must provide a %s.')
        );
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->changePasswordAccess();
        }
        else {
            if($this->mainModel->changeUserPassword($_SESSION['userId'])) {
                $data['successMessage'] = '<div class="success">Password changed successfully!</div>';
                $this->currentPage('login', $data);
            }
            $data['error'] = 'Database error occurred, resend!';
            $this->currentPage('login', $data);
        }
    }
}

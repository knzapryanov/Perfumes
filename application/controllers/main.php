<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MyController {
    
    public function index(){
        $data['manualNewest'] = $this->mainModel->indexRelation(12, '', 'is_newest');
        $data['promotions'] = $this->mainModel->indexRelation(12, '', 'is_sale');
        
        
        foreach($data as $var) {
         $var = $this->prepareOptionsToView($var);
        }
        
        $this->currentPage('index', $data);
    }
    
    public function prepareOptionsToView($products) {
        if(empty($products)) {
            return array();
        }
        
        foreach($products as $product) {

            $regularPriceArr = array();
            $salePriceArr = array();
            $percentageArr = array();

            $regularPriceToView = '';
            $salePricetToView = '';
            $percentageToView = '';

            foreach ($product->options as $option) {
                $regularPriceArr[] = $option->price;
                $salePriceArr[] = $option->sale_price;
                $percentageArr[] = $option->off_percentage;
            }

            $regularPriceMin = min($regularPriceArr);
            // manual search for sale price min because of possible 0 values when sale price is not specified
            $salePriceMin = 9999;
            foreach ($salePriceArr as $salePrice) {

                if($salePrice > 0 && $salePrice < $salePriceMin) {
                    $salePriceMin = $salePrice;
                }
            }

            $smallestOptionId = '';
            foreach ($product->options as $option) {

                if($option->sale_price == $salePriceMin){
                    $smallestOptionId = $option->id;
                }
            }

            // when some regular price is the smallest price we need only regular price in the view
            if ($regularPriceMin < $salePriceMin) {
                $regularPriceToView = '&euro; ' .$regularPriceMin;
            }
            // when some sale price is smallest wee need also the other corresponding values(regular price, percentage)
            else {
                $salePriceMinIndex = array_search($salePriceMin, $salePriceArr);
                $regularPriceToView = '<del>&euro; ' .$regularPriceArr[$salePriceMinIndex] . '</del>';
                $salePricetToView = '&euro; ' .$salePriceMin;
                $percentageToView = $percentageArr[$salePriceMinIndex];
            }

            $product->price = $regularPriceToView;
            $product->salePrice = $salePricetToView;
            $product->percentage = $percentageToView;
            $product->smallestOptionId = $smallestOptionId;
        }

        return $products;
    }
         
    public function generateEncryptStr(){
    $str = md5(md5(time()));
    
    return $str;
    
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
            $data['message'] = 'This email does not exist in our database!!!';
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
    
    
    public function products() {
        $products = $this->mainModel->getFilteredProducts();
        
        
        
        if(is_array($products['sorted'])) {
              $products['sorted'] = $this->prepareOptionsToView($products['sorted']);
            }
        
        if(!isset($products['nextPageProductsCount'])) {
            $products = array(
                'sorted' => array(),
                'nextPageProductsCount' => 0
            );
        }    
            
        $products['brands'] = $this->mainModel->getAllBrandIdName();
  
       
        
        $this->currentPage('products', $products);
    }
    
    public function searchByName() {
        $products = $this->mainModel->getSearchProducts();
     
        if(is_array($products['sorted'])) {
              $products['sorted'] = $this->prepareOptionsToView($products['sorted']);
        }
        else {
            redirect('index');
            // fuck hacker!!
        }
        
        $this->currentPage('search', $products);
    }

    public function filteredProducts() {
        if($this->input->is_ajax_request()) {

            $products = $this->mainModel->getFilteredProducts();
            // this contain products data and nextPage elem from array
            
            if(is_array($products['sorted'])) {
              $products['sorted'] = $this->prepareOptionsToView($products['sorted']);
                
               echo json_encode($products);
            }
            else {
               echo false;
            }
        }
    }
    
   
    public function loadManual() {
        if($this->input->is_ajax_request()) {
            $return = $this->mainModel->getIndexProducts($this->input->post('page'));
            
            if(!$return) {
                echo false;
            }
            else {
                echo json_encode($return);
            }
        }
    }
    
    public function loadPromotions() {
        if($this->input->is_ajax_request()) {
            $return = $this->mainModel->getIndexProducts($this->input->post('page'), 12, 'is_sale');
            
            if(!$return) {
                echo false;
            }
            else {
                echo json_encode($return);
            }
        }
    }
    
    public function product($slug) {
     
        $data['product'] = $this->mainModel->getProduct($slug);
        $data['category'] = $this->mainModel->getCategoryById($data['product']->cat_id);
        $data['relatedProducts'] = $this->mainModel->getRelatedByCategory($data['product']->cat_id);
        $data['relatedProducts'] = $this->prepareOptionsToView($data['relatedProducts']);
        
        /*echo '<pre>';
        print_r($data);
        echo '<pre>';
        die;*/
        
        $this->currentPage('product', $data);
    }

    public function checkout() {

        $this->currentPage('checkout');
    }
}

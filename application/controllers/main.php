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
            $quantity = '';
            $quantityArr = array();
            
            foreach ($product->options as $option) {
                $regularPriceArr[] = $option->price;
                $salePriceArr[] = $option->sale_price;
                $percentageArr[] = $option->off_percentage;
                $quantityArr[] = $option->quantity;
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

            // bug fix
            // if we have $salePriceMin == 9999 this is product with no sell price at all
            // we should search for minimal price option according $regularPriceMin not $salePriceMin
            if($salePriceMin != 9999) {

                foreach ($product->options as $option) {

                    if($option->sale_price == $salePriceMin){
                        $smallestOptionId = $option->id;
                        $quantity = $option->quantity;
                    }
                }
            }
            else{

                foreach ($product->options as $option) {

                    if($option->price == $regularPriceMin){
                        $smallestOptionId = $option->id;
                        $quantity = $option->quantity;
                    }
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
            $product->quantity = $quantity;
            $product->quantityString = implode(',', $quantityArr);
            /*echo '<pre>';
            print_r($product->quantityString);
            echo '</pre>';*/
        }

        return $products;
    }
         
    public function generateEncryptStr(){
    $str = md5(md5(time()));
    
    return $str;
    
    }
    
    public function logout(){
             unset($_SESSION['token'], $_SESSION['tokenPayment']);
             
             $this->session->sess_destroy();
	     redirect('');
    }

    public function login(){
        unset($_SESSION['token'], $_SESSION['tokenPayment']);
        
        $this->currentPage('login');
    }
    
    public function profile() {
        $sessionInfo = $this->session->all_userdata();
        
        if($sessionInfo['id']) {
            
            $data['address'] = $this->mainModel->getUserAddress($sessionInfo);
            $orderedProducts = $this->mainModel->getUserOrderedProducts($sessionInfo);

            // get the unique order id's among all ordered products
            $userOrdersIDs = array();
            foreach ($orderedProducts as $product) {

                $userOrdersIDs[] = $product->order_id;
            }
            $userOrdersIDs = array_unique($userOrdersIDs);

            // fill the array with orders containing all products from current order_id
            $data['orders'] = array();
            foreach ($userOrdersIDs as $orderID) {

                foreach ($orderedProducts as $product) {

                    if($product->order_id == $orderID) {

                        $data['orders'][$orderID][] = $product;
                    }
                }
            }

            $this->currentPage('profile', $data);
        }
        else {
            redirect('index');
        } 
    }
    
    public function saveProfileInfo() {

        if($this->input->post('saveProfile')) {
            self::returnMessageProfile();
        }
        else {
            redirect('profile');
        }
    }
    
    public function returnMessageProfile() {

        if($this->mainModel->saveProfileInfoDatabase()) {
             $this->flashData('message','Your address information has been saved successfully');
        }
        else {
            $this->flashData('message','Your address information has not been saved successfully');
        }

       redirect('profile');
    }
    
    public function confirmAddress() {

        $data = array();
        if(isset($_SESSION['id'])) {

            $sessionInfo = $this->session->all_userdata();
            $data['address'] = $this->mainModel->getUserAddress($sessionInfo);
        }
        
        $data['token'] = $this->generateEncryptStr();
        $_SESSION['tokenPayment'] = $data['token'];
        
        $this->currentPage('set_address', $data);
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
            else {

                $data['error'] = 'Database error occurred, resend!';
                $this->currentPage('register', $data);
            }
        }
    }

    public function signEmail() {

        if($this->input->is_ajax_request()) {

            $this->load->helper(array('form', 'url'));

            $this->load->library('form_validation');

            $this->form_validation->set_rules('sign_email', 'Email', 'trim|required|valid_email|is_unique[newsletter_signed.email]');

            if ($this->form_validation->run() == FALSE) {

                echo false;
            }
            else {

                if($this->mainModel->signNewsEmail()) {
                    

                    echo true;
                }
                else {

                    echo false;
                }
            }
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
            /*echo '<pre>';
            print_r($products);
            echo '</pre>';
            die;*/
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
                /*echo '<pre>';
            print_r($products['sorted']);
            echo '</pre>';*/

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

        
        $this->currentPage('product', $data);
    }

    public function checkout() {

        $this->currentPage('checkout');
    }

    public function payment() {
        $token = isset($_SESSION['tokenPayment']) ? $_SESSION['tokenPayment'] : false;
      
        if($this->input->post('token') !== $token) {
            redirect('index');
        }
        else {
         $this->currentPage('payment');
        }
    }
    
    // PAYPAL METHODS
    
    // functions.php
    function check_txnid($tnxid){
            global $link;
            return true;
            $valid_txnid = true;
            //get result set
            $sql = mysql_query("SELECT * FROM `payments` WHERE txnid = '$tnxid'", $link);
            if ($row = mysql_fetch_array($sql)) {
                    $valid_txnid = false;
            }
            return $valid_txnid;
    }

    function check_price($price, $id){
            $valid_price = false;
            //you could use the below to check whether the correct price has been paid for the product

            /*
            $sql = mysql_query("SELECT amount FROM `products` WHERE id = '$id'");
            if (mysql_num_rows($sql) != 0) {
                    while ($row = mysql_fetch_array($sql)) {
                            $num = (float)$row['amount'];
                            if($num == $price){
                                    $valid_price = true;
                            }
                    }
            }
            return $valid_price;
            */
            return true;
    }

    function updatePayments($data){
            global $link;

            if (is_array($data)) {
                    $sql = mysql_query("INSERT INTO `payments` (txnid, payment_amount, payment_status, itemid, createdtime) VALUES (
                                    '".$data['txn_id']."' ,
                                    '".$data['payment_amount']."' ,
                                    '".$data['payment_status']."' ,
                                    '".$data['item_number']."' ,
                                    '".date("Y-m-d H:i:s")."'
                                    )", $link);
                    return mysql_insert_id($link);
            }
    }
    
    
    public function payments() {
                // PayPal settings
        $paypal_email = 'novdomplovdiv@gmail.com';
        $return_url = 'http://localhost/pay/payment-successful.html';
        $cancel_url = 'http://domain.com/payment-cancelled.html';
        $notify_url = 'http://domain.com/payments.php';

        //$item_name = 'Test Item';
        //$item_amount = 5.00;

        // Include Functions
    //    include("functions.php");

        // Check if paypal request or response
        if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){
                $querystring = '';

                // Firstly Append paypal account to querystring
                $querystring .= "?business=".urlencode($paypal_email)."&";

                // Append amount& currency (£) to quersytring so it cannot be edited in html

                //The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
        //	$querystring .= "item_name=".urlencode($item_name)."&";
        //	$querystring .= "amount=".urlencode($item_amount)."&";

                //loop for posted values and append to querystring
                foreach($_POST as $key => $value){
                        $value = urlencode(stripslashes($value));
                        $querystring .= "$key=$value&";
                }


                // Redirect to paypal IPN
                header('location:https://www.paypal.com/cgi-bin/webscr'.$querystring);
                exit();
        } else {
                //Database Connection
                $link = mysql_connect($host, $user, $pass);
                mysql_select_db($db_name);

                // Response from Paypal

                // read the post from PayPal system and add 'cmd'
                $req = 'cmd=_notify-validate';
                foreach ($_POST as $key => $value) {
                        $value = urlencode(stripslashes($value));
                        $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
                        $req .= "&$key=$value";
                }

                // assign posted variables to local variables
                $data['item_name']			= $_POST['item_name'];
                $data['item_number'] 		= $_POST['item_number'];
                $data['payment_status'] 	= $_POST['payment_status'];
                $data['payment_amount'] 	= $_POST['mc_gross'];
                $data['payment_currency']	= $_POST['mc_currency'];
                $data['txn_id']				= $_POST['txn_id'];
                $data['receiver_email'] 	= $_POST['receiver_email'];
                $data['payer_email'] 		= $_POST['payer_email'];
                $data['custom'] 			= $_POST['custom'];

                // post back to PayPal system to validate
                $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
                $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
                $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

                $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

                if (!$fp) {
                        // HTTP ERROR

                } else {
                        fputs($fp, $header . $req);
                        while (!feof($fp)) {
                                $res = fgets ($fp, 1024);
                                if (strcmp($res, "VERIFIED") == 0) {

                                        // Used for debugging
                                        // mail('user@domain.com', 'PAYPAL POST - VERIFIED RESPONSE', print_r($post, true));

                                        // Validate payment (Check unique txnid & correct price)
                                        $valid_txnid = $this->check_txnid($data['txn_id']);
                                        $valid_price = $this->check_price($data['payment_amount'], $data['item_number']);
                                        // PAYMENT VALIDATED & VERIFIED!
                                        if ($valid_txnid && $valid_price) {

                                                $orderid = $this->updatePayments($data);

                                                if ($orderid) {
                                                        // Payment has been made & successfully inserted into the Database
                                                } else {
                                                        // Error inserting into DB
                                                        // E-mail admin or alert user
                                                        // mail('user@domain.com', 'PAYPAL POST - INSERT INTO DB WENT WRONG', print_r($data, true));
                                                }
                                        } else {
                                                // Payment made but data has been changed
                                                // E-mail admin or alert user
                                        }

                                } else if (strcmp ($res, "INVALID") == 0) {

                                        // PAYMENT INVALID & INVESTIGATE MANUALY!
                                        // E-mail admin or alert user

                                        // Used for debugging
                                        //@mail("user@domain.com", "PAYPAL DEBUGGING", "Invalid Response<br />data = <pre>".print_r($post, true)."</pre>");
                                }
                        }
                fclose ($fp);
                }
        }
    }
}

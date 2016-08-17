<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MyController {

	public function index(){
            $data['manualNewest'] = $this->mainModel->indexRelation(12, '', 'is_newest');
            $data['promotions'] = $this->mainModel->indexRelation(12, '', 'is_sale');

            foreach($data as $i => $var) {
                    if(empty($var)) {
                        $data['empty'.$i] = true;
                    }
                    
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

				 $regToken = $this->generateEncryptStr();
				 $userEmail = $this->input->post('email');
				 $userId = $this->mainModel->getUserIdByEmail($userEmail);

				 $this->mainModel->insertUserToken($regToken, $userId);
				 $this->sendConfirmationEmail($regToken, $userId);
				 $data['successMessage'] = '<div class="success">Successfully registered! Check you email to confirm your registration!</div>';
				 $this->currentPage('login', $data);
			}
			else {

				$data['error'] = 'Database error occurred, resend!';
				$this->currentPage('register', $data);
			}
		}
	}

	public function sendConfirmationEmail($regToken, $userId) {

		$this->load->library('email');
		$this->email->from('perfumes@wakeprojects.com', 'Perfumes.com');
		$this->email->to($this->input->post('email'));

		$link = "Please follow the link to confirm your registration in Perfumes.com<br />";
		$link .= "http://wakeprojects.com/Perfumes/confirmRegistration?id=".$userId;
		$link .= "&confirmToken=".$regToken;

		$this->email->message($link);
		$this->email->subject('Perfumes.com registration');
		$send = $this->email->send();
	}

	public function confirmRegistration() {

		if(isset($_GET['confirmToken']) && isset($_GET['id'])){

			$getToken = $_GET['confirmToken'];
			$getId = $_GET['id'];
			$isUserConfirmed = $this->mainModel->confirmUser($getToken, $getId);

			if($isUserConfirmed) {

				$data['message'] = 'Your email is successfully confirmed ! You can log in now !';
			}
			else {

				$data['message'] = 'Your email is NOT confirmed ! Please contact the site administration !';
			}
			$this->currentPage('regConfirmation', $data);
		}
		else{
			redirect('');
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
		$this->email->from('perfumes@wakeprojects.com', 'Perfumes.com');
		$this->email->to($this->input->post('email'));

		// generate token
		$_SESSION['token'] = $this->generateEncryptStr();
		$userEmail = $this->input->post('email');
		$userId = $this->mainModel->getUserIdByEmail($userEmail);

		$link = "Follow the link to change your password in Perfumes.com<br />";
		$link .= "http://wakeprojects.com/Perfumes/changePasswordAccess?id=".$userId;
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

			$data = array();

		// the user is registered
			if(isset($_SESSION['id'])) {

				$sessionInfo = $this->session->all_userdata();
				$data['address'] = $this->mainModel->getUserAddress($sessionInfo);
				if($_POST['deliveryHiddenInput'] == 0){
					$data['deliveryCost'] = 0;
				}
				else{

					$data['deliveryCost'] = 10;
				}
			}
			// the user is guest
			else {

				$data['address'] = array();
				$data['address']['first_name'] = $_POST['first_name'];
				$data['address']['last_name'] = $_POST['lasst_name'];
				$data['address']['country'] = 'MT';
				$data['address']['street'] = $_POST['street_address'];
				$data['address']['city'] = $_POST['city'];
				$data['address']['zip'] = $_POST['postcode'];
				$data['address']['phone'] = $_POST['mobile_number'];
				$data['address']['email'] = $_POST['email'];

				$guestId = $this->mainModel->insertGuestShippingInfo($data['address']);
				$_SESSION['guest_id'] = $guestId;

				if($_POST['deliveryHiddenInput'] == 0){
					$data['deliveryCost'] = 0;
				}
				else{

					$data['deliveryCost'] = 10;
				}
			}

			$this->currentPage('payment', $data);
		}
	}

	public function logMesssageToFile($filePath, $message) {

		// Open the file to get existing content
		$current = file_get_contents($filePath);

		// Append the new message to the file
		$current .= "\n" . $message;

		// Write the contents back to the file
		file_put_contents($filePath, $current);
	}

	public function successPayment() {

		//echo "<pre>".var_dump($_POST)."</pre>";
		//die;

		$this->currentPage('successPayment');
	}

	public function cancelPayment() {

		$this->currentPage('cancelPayment');
	}

	// PAYPAL METHODS

	// functions.php
	function check_txnid($tnxid){
			global $link;
			return true;
			$valid_txnid = true;
			//get result set
			$sql = mysqli_query("SELECT * FROM `payments` WHERE txnid = '$tnxid'", $link);
			if ($row = mysqli_fetch_array($sql)) {
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

        private function exitFunction($paypal_email, $user_id) {
            $this->logMesssageToFile('logMessages.txt', 'paypal request');
            $querystring = '';

            // Firstly Append paypal account to querystring
            $querystring .= "?business=".urlencode($paypal_email)."&";

            // Append amount& currency (£) to quersytring so it cannot be edited in html

            //loop for posted values and append to querystring
            foreach($_POST as $key => $value){
                $value = urlencode(stripslashes($value));
                $querystring .= "$key = $value&";
            }

            // Append querystring with custom field
            $querystring .= "custom=" . $user_id ."&amp;amp;amp;amp;amp;amp;";

            // Redirect to paypal IPN
            header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
            exit();
        }
        
	public function payments() {
            // PayPal settings
            $paypal_email = 'novdomplovdiv-facilitator@gmail.com';
            
            if(isset($_SESSION['id'])) {
                $user_id = $_SESSION['id'];
            }
            else {
                $user_id = 'guest';
                $guest_id = $_SESSION['guest_id'];
                $user_id = $user_id . '-' . $guest_id;
            }

            // Check if paypal request or response
            $this->logMesssageToFile('logMessages.txt', 'vliza vuv payments');

            if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){
                
                self::exitFunction($paypal_email, $user_id);
            } 
            else {
               // lets make it!
               self::proceedPaypal(); 
            }
	}
        
        private function proceedPaypal() {
            $this->logMesssageToFile('logMessages.txt', 'paypal response');
            $this->logMesssageToFile('logMessages.txt', 'POST array:');
            
            foreach ($_POST as $key => $value) {
               $this->logMesssageToFile('logMessages.txt', $key . ' = ' . $value);
            }

            // Response from Paypal

            // read the post from PayPal system and add 'cmd'
            $req = 'cmd=_notify-validate';
            foreach ($_POST as $key => $value) {
                $value = urlencode(stripslashes($value));
                $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value);// IPN fix
                $req .= "&$key = $value";
            }

            // assign posted variables to local variables
            $data['txn_id']			= $_POST['txn_id'];
            $data['payer_id']			= $_POST['payer_id'];
            $data['payer_email']		= $_POST['payer_email'];
            $data['payment_amount'] 		= $_POST['mc_gross'];
            $data['payment_currency'] 		= $_POST['mc_currency'];
            $data['payment_type'] 		= $_POST['payment_type'];
            $data['payment_status'] 		= $_POST['payment_status'];

            // post back to PayPal system to validate

            $header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
            $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $header .= "Host: www.sandbox.paypal.com\r\n";  // www.paypal.com for a live site
            $header .= "Content-Length: " . strlen($req) . "\r\n";
            $header .= "Connection: close\r\n\r\n";

            $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

            if (!$fp) {
                // HTTP ERROR
                $this->logMesssageToFile('logMessages.txt', 'fp HTTP ERROR');
            } 
            
            else {
                // lets go deeper
                self::httpSuccess($fp, $header, $req, $data);
            }
        }
        
        private function httpSuccess($fp, $header, $req, $data) {
           $this->logMesssageToFile('logMessages.txt', 'fp HTTP SUCCESS');
           fputs($fp, $header . $req);
           
           while (!feof($fp)) {
               
            $res = fgets ($fp, 1024);
             //$this->logMesssageToFile('logMessages.txt', 'res = ' . $res);
            if (stripos($res, "VERIFIED") !== false) {
                
                self::paymentVerified($data);
                
            }  // verif
            else if (stripos($res, "INVALID") !== false) {
                $this->logMesssageToFile('logMessages.txt', ' else if res INVALID');
                // PAYMENT INVALID & INVESTIGATE MANUALY!
                // E-mail admin or alert user

                // Used for debugging
                //@mail("user@domain.com", "PAYPAL DEBUGGING", "Invalid Response<br />data = <pre>".print_r($post, true)."</pre>");
            }
           }
          
           fclose ($fp);
        }
        
        private function paymentVerified($data) {
            
            $this->logMesssageToFile('logMessages.txt', 'res VERIFIED');
            // Used for debugging
            // mail('user@domain.com', 'PAYPAL POST - VERIFIED RESPONSE', print_r($post, true));

            // Validate payment (Check unique txnid & correct price)
            $valid_txnid = $this->check_txnid($data['txn_id']);
            $valid_price = $this->check_price($data['payment_amount'], $data['item_number']);
		
            // PAYMENT VALIDATED & VERIFIED!
            if ($valid_txnid && $valid_price) {
                
               $this->logMesssageToFile('logMessages.txt', 'PAYMENT VALIDATED & VERIFIED');
               $orderid = $this->mainModel->updatePayments($data);
               $this->logMesssageToFile('logMessages.txt', 'order_id = ' . $orderid);
               
               $this->logMesssageToFile('logMessages.txt', 'Payment has been made & successfully inserted into the Database');
               // Payment has been made & successfully inserted into the Database

                $userId = $_POST['custom'];
                $userIdArr = explode("-", $userId);		

                if($userIdArr[0] == 'guest') {
                    // $userIdArr[1] is the guestId which comes from the custom parameter sent prom paypal request url							
                    $shippingInfoStr = $this->genGuestShippingInfo($userIdArr[1]);
                }
                else {

                    $shippingInfoStr = $this->genRegUserShippingInfo($userId);
                }                                                        

                $cartItemsCount = $_POST['num_cart_items'];

                self::dbOperations($cartItemsCount, $userId, $orderid, $shippingInfoStr);
            } 

            else {
                $this->logMesssageToFile('logMessages.txt', 'Payment made but data has been changed');
                // Payment made but data has been changed
                // E-mail admin or alert user
            }
                        
        }
        
        private function dbOperations($cartItemsCount, $userId, $orderid, $shippingInfoStr) {
            $this->logMesssageToFile('logMessages.txt', 'cartItemsCount = ' . $cartItemsCount);
            
            for($i = 1; $i <= $cartItemsCount; $i++) {

                $postItemNumber = 'item_number' . $i;
                $productId = $_POST[$postItemNumber];
                $postItemName = 'item_name' . $i;
                $postItemML = 'option_selection1_' . $i;
                $productML = $_POST[$postItemML];
                $postItemTotal = 'mc_gross_' . $i;
                $postItemQty = 'quantity' . $i;
                $itemTotalPrice = $_POST[$postItemTotal];
                $itemQty = $_POST[$postItemQty];
                $itemPrice = $itemTotalPrice / $itemQty;
                $postItemIMG = 'option_selection2_' . $i;

                $ordersData['user_id'] = $userId;
                $ordersData['order_id'] = $orderid;
                $ordersData['product_id'] = $productId;
                $ordersData['product_name'] = $_POST[$postItemName];
                $ordersData['order_ml'] = $productML;
                $ordersData['option_price'] = $itemPrice;
                $ordersData['order_date'] = time();
                $ordersData['image_src'] = $_POST[$postItemIMG];
                $ordersData['qty'] = $itemQty;
                $ordersData['total_price_ml'] = $itemTotalPrice;
                $ordersData['shipping_info'] = $shippingInfoStr;

                $isProductSaved = $this->mainModel->insertProductInOrders($ordersData);
                //$updateResult = $this->mainModel->updateProductQty($productId, $productML, $itemQty);
                $brandSaleCountMessage = $this->mainModel->updateBrandSale($productId, $itemQty);

                //$this->logMesssageToFile('logMessages.txt', 'updateResult = ' . $updateResult);
                $this->logMesssageToFile('logMessages.txt', 'brand sale message= ' . $brandSaleCountMessage);

                if($isProductSaved){

                        $this->logMesssageToFile('logMessages.txt', 'Product ' . $i . ' inserted!');
                }
                else {

                        $this->logMesssageToFile('logMessages.txt', 'Product ' . $i . ' NOT inserted!');
                }
                
            } // for loop end
        }

        public function genRegUserShippingInfo($userId) {

		 $shippingInfoArr = $this->mainModel->getUserAddressById($userId);
		 $this->logMesssageToFile('logMessages.txt', 'shippingInfoArr = ' . $shippingInfoArr);
		 foreach ($shippingInfoArr as $key => $value) {
				 $this->logMesssageToFile('logMessages.txt', 'from function shippingInfoArr = ' . $key . ' = ' . $value);
		 }

		 $shippingInfoStr = $shippingInfoArr['street'] . ' ' . $shippingInfoArr['city'] . ' ' . $shippingInfoArr['zip'] . ' ' . $shippingInfoArr['country'] . ' Name: ' . $shippingInfoArr['first_name'] . ' ' . $shippingInfoArr['last_name'] . ' Email: ' . $shippingInfoArr['email'] . ' Phone: ' . $shippingInfoArr['phone'];

		 $this->logMesssageToFile('logMessages.txt', 'shippingInfoStr = ' . $shippingInfoStr);

		 return $shippingInfoStr;
	}

	public function genGuestShippingInfo($guestId) {

		$shippingInfoArr = $this->mainModel->getGuestAddressById($guestId);

		$shippingInfoStr = $shippingInfoArr['street'] . ' ' . $shippingInfoArr['city'] . ' ' . $shippingInfoArr['zip'] . ' ' . $shippingInfoArr['country'] . ' Name: ' . $shippingInfoArr['first_name'] . ' ' . $shippingInfoArr['last_name'] . ' Email: ' . $shippingInfoArr['email'] . ' Phone: ' . $shippingInfoArr['phone'];

		return $shippingInfoStr;
	}
}

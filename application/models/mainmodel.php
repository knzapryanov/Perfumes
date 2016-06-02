<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MainModel extends CI_Model {
    public function validationUser(){
       $data = array(
         'email' => $this->input->post('email'),
         'password' => $this->input->post('password'),
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

   public function changeUserPassword($userId) {
       $data = array(
           'password' => $_POST['password']
       );

       $this->db->where('id', $userId);
       $this->db->update('users', $data);
       unset($_SESSION['token']);
       unset($_SESSION['userId']);
   }

   public function getUserIdByEmail($userEmail) {
       $query = $this->db->get_where('users', array('email' => $userEmail));
       return $query->row()->id;
   }

   public function getAllBrands() {
       $query = $this->db->get('brands');
       return $query->result();
   }

   public function getAllCategories(){
       $query = $this->db->get('categories');
       return $query->result();
   }

   public function  insertProductInDB() {
       $post = $this->input->post();
     
       
       $productTable = array(
          'product_name' => $post['product_name'], 
          'brand_id' => $post['brand_id'], 
          'cat_id' => $post['cat_id'],
          'created_time' => time()
       );
       
       $isSuccess = $this->db->insert('products', $productTable);
       $lastId = $this->db->insert_id();
       
       $this->productOptions($lastId, $post['mlArray']);
       
       $this->saveImages($lastId, $post['images']);
       
       $manuals = isset($post['manualNewest']) ? $post['manualNewest'] : array();
       
       $this->manualProducts($lastId, $manuals, $post['addToNewest']);
       
       
       
       if($isSuccess) {
           return true;
       }

       return false;
   }
   
   public function productOptions($lastId, $mlArray) {
//       foreach($mlArray as $index => $ml) {
//           $options = array(
//               'product_id' => $lastId,
//               'ml' => $ml[$index][0], // ml
//               'price' => $ml[$index][1], //price
//               'sale_price' => $ml[$index][2],//sale_price
//               'off_percentage' => $ml[$index][3], // off_percentage
//               'quantity' => $ml[$index][4] // 'quantity'
//           );
//           
           for($i = 0; $i < count($mlArray); $i++) {
               $options = array(
               'product_id' => $lastId,
               'ml' => $mlArray[$i][0], // ml
               'price' => $mlArray[$i][1], //price
               'sale_price' => $mlArray[$i][2],//sale_price
               'off_percentage' => $mlArray[$i][3], // off_percentage
               'quantity' => $mlArray[$i][4] // 'quantity'
               );
             $this->db->insert('product_options', $options);

           }
           
//       }
   }
   
   public function manualProducts($lastId, $manuals, $added) {
       $this->db->empty_table('manual_newest');
       
       
       if($added) {
           $manuals[] = $lastId;
       }
   
       foreach($manuals as $product) {
          $this->db->insert('manual_newest', array('product_id' => $product));
       }
       
   }
   
   public function saveImages($lastId, $images) {
       $index = 0;
       foreach($images as $image) {
           $isCover = 0;
           if($index === 0) {
               $isCover = 1;
           } 
           
           $dataImage = array(
               'product_id' => $lastId,
               'source' => $image,
               'is_cover' => $isCover,
           );
           
           $index++;
           
           $this->db->insert('pictures', $dataImage);
       }
   }
   
   
   public function getManualProducts() {
            $this->db->select('*');
            $this->db->order_by('product_name ASC');
            $this->db->from('manual_newest m'); 
            $this->db->join('products p', 'm.product_id = p.id', 'left');
            //$this->db->join('product_options po', 'm.product_id = po.product_id', 'left');
            //$this->db->join('pictures pi', 'm.product_id = pi.product_id', 'left');
            $query = $this->db->get(); 
            
            if($query->num_rows() !== 0)
            {
                return $query->result_array();
            }
            else
            {
                return false;
            }
   }

    public function getProductOptionsByProducId($productId){
        $query = $this->db->get_where('product_options', array('product_id' => $productId));
        return $query->result_array();
    }

    public function getProductPicturesByProducId($productId){
        $query = $this->db->get_where('pictures', array('product_id' => $productId));
        return $query->result_array();
    }

    public function getBiggestOffPercentByProductId($productId){
        $query = $this->db->get_where('product_options', array('product_id' => $productId));
        //$resultArr =
        return $query->row()->off_percentage;
    }
}
    
    
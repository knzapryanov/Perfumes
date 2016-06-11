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
          'description' => $post['description'], 
          'brand_id' => $post['brand_id'], 
          'cat_id' => $post['cat_id'],
          'is_newest' => $post['addToNewest'],
          'created_time' => time()
       );
       
       $isSuccess = $this->db->insert('products', $productTable);
       $lastId = $this->db->insert_id();
       
       $this->productOptions($lastId, $post['mlArray']);
       
       $this->saveImages($lastId, $post['images']);
       
       if($isSuccess) {
           $manuals = $this->getManualProducts();
           
           return $manuals;
       }

       return false;
   }
   
   public function updateProductInDB() {
       $post = $this->input->post();
       $currentId = $post['product_id'];

       $productTable = array(
          'product_name' => $post['product_name'], 
          'description' => $post['description'], 
          'brand_id' => $post['brand_id'], 
          'cat_id' => $post['cat_id'],
          'is_newest' => (int)$post['addToNewest'],
       );
       
       $isSuccess = $this->db->where('id', $currentId)->update('products', $productTable);
       
       $this->productOptions($currentId, $post['mlArray'], true);
       
       $this->saveImages($currentId, $post['images'], true);
       
       if($isSuccess) {
           $manuals = $this->getManualProducts();
           
           return $manuals;
       }

       return false;
       
       
   }
   
   
   public function productOptions($lastId, $mlArray, $isUpdate = false) {
        
       if($isUpdate) {
          $this->db->where('product_id', $lastId)->delete('product_options');
       }
       
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
   }
   
   public function updateNew() {
       $success = $this->db
               ->where('id', $this->input->post('id'))
               ->update('products', array('is_newest' => $this->input->post('is_newest')));
       
       if($success) {
           return true;
       }
       
       return false;
       
   }
   
   public function saveImages($lastId, $images, $isUpdate = false) {
       if($isUpdate) {
           $this->db->where('product_id', $lastId)->delete('pictures');
       }

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
            $this->db->select('id, product_name');
            $this->db->from('products');
            $this->db->where('is_newest', 1);
            $this->db->order_by('product_name ASC');
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
    
    public function deleteBrandById() {
        return $this->db->where('id', $this->input->post('id'))->delete('brands');
    }
    
    public function deleteProductById() {
        return $this->db->where('id', $this->input->post('id'))->delete('products');
    }
    
    public function createBrand() {
        $brand = $this->db->insert('brands', $this->input->post());
        
        if($brand) {
            return array(
                'id' => $this->db->insert_id()
            );
        }
        
        return false;
    }
    
    public function getProducts($get = false) {
        $baseURL = base_url().'admin/all_products/'; 

        $page = 0;
        
       if($get !== false) {
           $page = isset($get['page']) ? $get['page'] * 10 : 0;
           
           $this->db->like('product_name', $get['product_name']);
       } 
       
       
       $count = $this->db->get('products')->num_rows;
   
       $result_count = $count;

        $config['base_url'] = $baseURL; 
        $config['total_rows'] = $result_count;
        $config['per_page']= 10;
        $config['num_links'] = 20; 
        $config['enable_query_strings'] = TRUE;
    
        
        
        $this->pagination->initialize($config);

    
        $this->db->select('id, product_name');
        $this->db->like('product_name', !$get ? '' : $get['product_name']);
        $this->db->order_by('product_name','asc');
        
        $data = array(
            'products' => $this->db->get('products', $config['per_page'], $page)->result(),
            'nextPage' => $this->db->get('products',$config['per_page'], $page + 10)->num_rows()
         );
        
        return $data;
    }
 
}
    
    
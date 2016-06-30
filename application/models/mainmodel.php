<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MainModel extends myModel {
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
       if ($query->num_rows() > 0) {
           return $query->row()->id;
       } else {
           return false;
       }
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
          'is_sale' => $post['is_sale'],
          'slug' => $this->convertSlug($post['product_name']),
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
          'is_sale' => $post['is_sale'],
          'slug' => $this->convertSlug($post['product_name']), 
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

    public function getProducts($get = false, $perPage = 12) {
        $page = 0;
        
       if($get !== false) {
           $page = isset($get['page']) ? $get['page'] * $perPage : 0;
           
           $this->db->like('product_name', $get['product_name']);
       } 
    
        $this->db->select('id, product_name');
        $this->db->like('product_name', !$get ? '' : $get['product_name']);
        $this->db->order_by('product_name','asc');
        
        $data = array(
            'products' => $this->db->get('products', $perPage, $page)->result(),
            'nextPage' => $this->db->get('products', $perPage, $page + $perPage)->num_rows()
         );
        
        return $data;
    }
    
    public function getIndexProducts($page = 0, $perPage = 12, $paramWhere = 'is_newest') {
        $page *= $perPage;
        
        $data = array(
            'products' => $this->indexRelation($perPage, $page, $paramWhere),
            'nextPage' => $this->db->where($paramWhere, 1)->get('products', $perPage, $page + $perPage)->num_rows()
         );
        
        shuffle($data['products']);
        
        return $data;
    }

    protected $cats = array(
        'men' => 1,
        'women' => 2,
        'top' => 3,
        'promo' => 4
    );

    public function productsRelation($get = array(), $offset = '') {
          $where = array(
                'cat_id' => 1,
         );

         if(!empty($get)) {
            $where = array(
                'cat_id' => $this->cats[$get['cat']],
             );
         }

//         $whereIn = isset($get['selected']) ? explode($get['selected']) : $this->getAllBrandIds();

        $data = $this->relation_product_model->
                where($where)->
//                where_in('brand_id', $whereIn)->
                with_pictures('where:`pictures`.`is_cover`=\'1\'')->
                with_options()->
                limit(6, $offset)->
                get_all();

        $sorted = $this->sortArray($data);
        // sort option for better view handling

        return $sorted;
    }


    public function getFilteredProducts($get = array(), $offset = '') {
        $where = array(
            'cat_id' => 1,
        );

        if(isset($_POST['category'])) {

            $where = array(
                'cat_id' => $this->cats[$_POST['category']],
            );
        }

        $fromValue = $_POST['fromValue'];
        $toValue = $_POST['toValue'];

        $data = $this->relation_product_model->
        where($where)->
        with_pictures('where:`pictures`.`is_cover`=\'1\'')->
        with_options('where:`product_options`.`price`>='. (int)$fromValue .' AND `product_options`.`price`<='. (int)$toValue .'')->
        //limit(6, $offset)->
        //as_array()->
        get_all();

        $filteredProductsData = array();
        foreach ($data as $product) {

            if(isset($product->options)) {
                $filteredProductsData[] = $product;
            }
        }

        if(count($filteredProductsData) > 0) {

            $sorted = $this->sortArray($filteredProductsData);

            return $sorted;
        }
        else {
            return false;
        }
    }
    
    public function sortArray($array) {
        foreach($array as $ar) {
         // Sort the multidimensional array
         usort($ar->options, array($this,'custom_sort'));
        }

        return $array;
    } 
    
   function custom_sort($a,$b) {
          return $a->ml > $b->ml;
   }
    
   public function getAllBrandIds() {
       $query = $this->db
               ->order_by('brand_name ASC')
               ->select('id')
               ->get('brands');
       return $query->result();
   }
    
    
     public function indexRelation($limit = 12, $offset = '', $param = false) {
        $data = $this->relation_product_model->
                where($param, 1)->
                with_pictures('where:`pictures`.`is_cover`=\'1\'')->
                with_options()->
                limit($limit, $offset)->
                get_all();
  
        shuffle($data);
        
        return $data;
    }
    
     public function getProduct($slug) {
        $product = $this->relation_product_model->
                where('slug', $slug)->
                with_pictures()->
                with_options()->
                get();
        
        return $product;
    }
    
    public function getCategoryById($id) {
        $query = $this->db->get_where('categories', array('id' => $id));
        return $query->row();
    }

    public function getRelatedByCategory($id) {
        $relatedProducts = $this->relation_product_model->
            where('cat_id', $id)->
            with_pictures()->
            with_options()->
            get_all();

        shuffle($relatedProducts);

        return $relatedProducts;
    }

}
    
    
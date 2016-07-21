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
        
        return $data;
    }

    protected $cats = array(
        'man' => 1,
        'woman' => 2,
        'top' => 3,
        'promo' => 4,
        'newest' => 5
    );
    
    
    public function getSearchProducts() {
         $like = self::buildLikeWhere($_GET['search']);
         if($like === false) {
             return false;
         }
         
         $products = $this->relation_product_model->
            where($like, NULL, NULL, FALSE, FALSE, true)->
            with_pictures('where:`pictures`.`is_cover`=\'1\'')->
            with_options('where:`product_options`.`quantity`>\'0\'')->
            get_all();
         
         
         // remove the products which have no options with price in the selected range
        $filtredProductsFinal = array();
        foreach ($products as $product) {
          
            if(isset($product->options) || count($product->options) > 0) {
                $filtredProductsFinal[] = $product;
            }
        }
            
         return array(
                'sorted' => $filtredProductsFinal === false ? array() : $filtredProductsFinal,
                'nextPageProductsCount' => 1
            );
         
         
    }
    
    public function buildLikeWhere($string) {
        $escapedString = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars
        
        if($escapedString === '') {
          return false;
        }
        
        $searchTerms = explode(' ', $escapedString);
        $searchTermBits = array();
        foreach ($searchTerms as $term) {
            $term = trim($term);
            if (!empty($term)) {
                $searchTermBits[] = "(product_name LIKE '%$term%' OR description LIKE '%$term%')";
            }
        }
        
        $result = implode(' OR ', $searchTermBits);

        return $result;
    }
    
    public function getFilteredProducts()
    {

        $perPage = 6;
        $get = $_GET;

        if (empty($get)) {
            $postFilter = $this->input->post();

            $postFilter['cat'] = isset($postFilter['cat']) ? $postFilter['cat'] : 'man';
            $postFilter['brand'] = isset($postFilter['brand']) ? $postFilter['brand'] : '';
            $postFilter['min'] = isset($postFilter['min']) ? $postFilter['min'] : 0;
            $postFilter['max'] = isset($postFilter['max']) ? $postFilter['max'] : 500;
            $postFilter['search'] = isset($postFilter['search']) ? $postFilter['search'] : '';
        } else {
            $postFilter = array(
                'cat' => isset($get['cat']) ? $get['cat'] : 'man',
                'brand' => isset($get['brand']) ? $get['brand'] : '',
                'min' => isset($get['min']) ? $get['min'] : 0,
                'max' => isset($get['max']) ? $get['max'] : 500,
                'search' => isset($get['search']) ? $get['search'] : '',
            );
        }

        $page = isset($postFilter['page']) ? $postFilter['page'] : 0;
        $startingProductForCurrentPage = $page * $perPage;
        $startingProductNextPage = $startingProductForCurrentPage + $perPage;

        $fromValue = $postFilter['min'];
        $toValue = $postFilter['max'];

        if ($this->cats[$postFilter['cat']] === 5) {
            // we have newest product search
            $products = $this->relation_product_model->
            order_by('created_time', 'ASC')->
            with_pictures('where:`pictures`.`is_cover`=\'1\'')->
            with_options('where:`product_options`.`price`>=' . (int)$fromValue . ' AND `product_options`.`price`<=' . (int)$toValue . ' AND `product_options`.`quantity`>\'0\'')->
            get_all();

        } else {
            $where = array('cat_id' => $this->cats[$postFilter['cat']]);

            // cat === 4 is promo cat
            $cat = $this->cats[$postFilter['cat']];
            if ($cat === 4) {
                $where = array('is_sale' => 1);
            } else if ($cat === 1 || $cat === 2) {
                $where = "cat_id = 3 OR cat_id = $cat";
            }


            $products = $this->relation_product_model->
            where($where, NULL, NULL, FALSE, FALSE, true)->
            with_pictures('where:`pictures`.`is_cover`=\'1\'')->
            with_options('where:`product_options`.`price`>=' . (int)$fromValue . ' AND `product_options`.`price`<=' . (int)$toValue . ' AND `product_options`.`quantity`>\'0\'')->
            get_all();

        }

        $filteredProductsData = array();

        if ($postFilter['brand'] === '') {
            $brands = $this->getAllBrandIds();
        } else {
            $brands = explode(';', $postFilter['brand']);
        }

        // filter further by brands fuck!
        foreach ($products as $product) {
            if (array_search($product->brand_id, $brands) !== false) {
                $filteredProductsData[] = $product;
            }
        }

        // remove the products which have no options with price in the selected range
        $filtredProductsFinal = array();
            foreach ($filteredProductsData as $product) {

                if (isset($product->options)) {
                    // only if we have options set check their count else you have nice bug :D
                    if(count($product->options) > 0) {
                        $filtredProductsFinal[] = $product;
                    }
                }
            }

        $filtredProductsFinalPagePart = array_slice($filtredProductsFinal, $startingProductForCurrentPage, $perPage);
        $filteredProductsFinalNextPage = array_slice($filtredProductsFinal, $startingProductNextPage, $perPage);
        $productsNextPageCount = count($filteredProductsFinalNextPage);

 

        if(count($filtredProductsFinal) > 0) {

            $sorted = $this->sortArray($filtredProductsFinalPagePart);

            return array(
                'sorted' => $sorted,
                'nextPageProductsCount' => $productsNextPageCount
            );
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
    
   public function getAllBrandIdName() {
       $query = $this->db
               ->order_by('brand_name ASC')
               ->select('id, brand_name')
               ->get('brands');
       return $query->result();
   }
   
    public function getAllBrandIds() {
       $query = $this->db
               ->select('id')
               ->get('brands');
       $arr = array();
       
       foreach ($query->result_array() as $row) {
        $arr[] = $row['id'];
       }
       
       return $arr;
   }
    
    
     public function indexRelation($limit = 12, $offset = '', $param = false) {

        //$perPage = 12;

        // not sure ! this returns object when the provided limit is not reached(in this example returned products are below 12)
        // and return array when the limit is reached fuck fuck fuck!
        $data = $this->relation_product_model->
                where($param, 1)->
                with_pictures('where:`pictures`.`is_cover`=\'1\'')->
                with_options('where:`product_options`.`quantity`>\'0\'')->
                limit($limit, $offset)->
                get_all();


        // cast the returned data to array in order to use shuffle and array_alice
        //$dataArr = get_object_vars($data);

        //$startPageProducts = array_slice($dataArr, 0, $perPage);
        //$startPageNext = array_slice($dataArr, 12, $perPage);
        //$productsNextPageCount = count($startPageNext);

        shuffle($data);

        // cast the shuffled array to object again since the controller is expecting object
        //$dataObj = (object)$dataArr;
        //$dataObj->nextPageProductsCount = $productsNextPageCount;

        return $data;
    }
    
     public function getProduct($slug) {
        $product = $this->relation_product_model->
                where('slug', $slug)->
                with_pictures()->
                with_options('where:`product_options`.`quantity`>\'0\'')->
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
             with_options('where:`product_options`.`quantity`>\'0\'')->
            get_all();

        
          // remove the products which have no options with price in the selected range
        $filtredProductsFinal = array();
        foreach ($relatedProducts as $product) {
          
            if(isset($product->options) || count($product->options) > 0) {
                $filtredProductsFinal[] = $product;
            }
        }
        
        shuffle($filtredProductsFinal);

        return $filtredProductsFinal;
    }

    public function getUserAddress($sessionInfo) {
            $this->db->select('*');
            $this->db->from('user_address');
            $this->db->join('users', 'users.id = user_address.user_id', 'LEFT');
            $this->db->where('user_address.user_id',$sessionInfo['id']);
            $query = $this->db->get();
            $address = $query->result_array();
            //$address = $address[0];

       if(empty($address)) {
           // build empty elements for array
           $address = array(
             'first_name' => $sessionInfo['first_name'],
             'last_name' => $sessionInfo['last_name'],
             'email' => $sessionInfo['email'],
             'street' => '',
             'city' => '',
             'country' => '',  
             'zip' => '',  
             'phone' => '',
           );

           return $address;
       }
 
       return $address[0];
    }

    public function getUserOrderedProducts($sessionInfo) {

        $userId = $sessionInfo['id'];
        $userOrders = $this->db->get_where('orders', array('user_id =' => $userId))->result();

        return $userOrders;
    }
    
    public function saveProfileInfoDatabase() {
        $post = $this->input->post();
        $userId = $this->session->userdata('id');

        // prepare data for update/insert
        $data = array(
               'street' => $post['street_address'],  
               'city' => $post['city'],  
               'country' => $post['country'],  
               'zip' => $post['postcode'],  
               'phone' => $post['mobile_number'],
            );
        
        $isUpdate = $this->db 
                ->where('user_id', $userId)
                ->get('user_address')
                ->num_rows();

        // update if user address exist
        if($isUpdate > 0) {
            
          return  $this->db
                    ->where('user_id', $userId)
                    ->update('user_address', $data);


        }

        $data['user_id'] = $userId;

        // insert if user address do not exist
        return $this->db->insert('user_address', $data);
    }
    
    
}
    
    
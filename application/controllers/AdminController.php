<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AdminController extends MyController {
     public function __construct() {
        parent::__construct();

        $this->load->model('relation_product_model');

        $ArrSession = $this->sessionData();
        $allowed = array(
            'index',
            'checkRole'
        );
       
        if(!in_array($this->router->fetch_method(), $allowed)) {
            if(!$ArrSession || $ArrSession['role'] === USER){
                 redirect('index', 'main');
            }
        }
    }

    public function index() {
        if(isset($_SESSION['role']) && $_SESSION['role'] == ADMIN) {
            $this->productPage();
        }
        else {
            $this->adminPage('admin/index');
        }
    }
    
    public function checkRole() {
       $this->permission('admin/productPage');
    }
    
    public function productPage() {
        $data['allBrandsResult'] = $this->mainModel->getAllBrands();
        $data['allCategoriesResult'] = $this->mainModel->getAllCategories();
        $data['manualProducts'] = $this->mainModel->getManualProducts();
        $this->adminPage('admin/admin_page', $data);
    }
    
    //* $field_name => Input file field name.
//* $target_folder => Folder path where the image will be uploaded.
//* $file_name => Custom thumbnail image name. Leave blank for default image name.
//* $thumb => TRUE for create thumbnail. FALSE for only upload image.
//* $thumb_folder => Folder path where the thumbnail will be stored.
//* $thumb_width => Thumbnail width.
//* $thumb_height => Thumbnail height.
//*
//**/
    function processUpload($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = ''){
        //folder path setup
        $target_path = $target_folder;
        $thumb_path = $thumb_folder;

        //file name setup
        $filename_err = explode(".",$_FILES[$field_name]['name']);
        $filename_err_count = count($filename_err);
        $file_ext = $filename_err[$filename_err_count-1];
        
               

        if($file_name != '')
        {
                $fileName = $file_name.'.'.$file_ext;
        }
        else
        {
                $fileName = $_FILES[$field_name]['name'];
        }
        

        //upload image path
        $upload_image = $target_path.basename($fileName);
        //upload image
        if(move_uploaded_file($_FILES[$field_name]['tmp_name'],$upload_image))
        {
                //thumbnail creation
                if($thumb == TRUE)
                {
                        $thumbnail = $thumb_path.$fileName;
                        list($width,$height) = getimagesize($upload_image);
                        $thumb_height = ($thumb_width/$width) * $height;
                        $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
                        
                        
                        switch($file_ext){
                                case 'jpg':
                                        $source = imagecreatefromjpeg($upload_image);
                                        break;
                                case 'jpeg':
                                        $source = imagecreatefromjpeg($upload_image);
                                        break;
                                case 'png':
                                        $source = imagecreatefrompng($upload_image);
                                        break;
                                case 'gif':
                                        $source = imagecreatefromgif($upload_image);
                                        break;
                                default:
                                        $source = imagecreatefromjpeg($upload_image);
                        }
                        imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
                        switch($file_ext){ 
                                case 'jpg' || 'jpeg':
                                        imagejpeg($thumb_create,$thumbnail,100);
                                        break;
                                case 'png':
                                        $targ_w_thumb = $targ_w_thumb = 200;
//                                        $dst_r = ImageCreateTrueColor($targ_w_thumb, $targ_h_thumb);
                                        imagealphablending($thumb_create, false);
                                        imagesavealpha($thumb_create, true);
                                        imagefill($thumb_create, 0, 0, imagecolorallocatealpha($thumb_create, 0, 0, 0, 127));
                                        imagecopyresampled($thumb_create, $this->image, 0, 0, $targ_x, $targ_y, $targ_w_thumb, $targ_h_thumb, $targ_w, $targ_h);
//                                        imagepng($thumb_create,$thumbnail, 9);    
                                    
                                    
                                        imagepng($thumb_create,$thumbnail,100);
                                        break;
                                case 'gif':
                                        imagegif($thumb_create,$thumbnail,100);
                                        break;
                                default:
                                        imagejpeg($thumb_create,$thumbnail,100);
                        }
                }

                return $fileName;
        }
        else
        {
                return false;
        }
    }
    
    public function doUpload() {
        if(!empty($_FILES['file']['name'])){
          
        $pathoToUpload = $_SERVER['DOCUMENT_ROOT'].'/Perfumes/assets/uploads/';
	
        $width = '269';
        $height = '340';
        
	$upload_img = $this->processUpload('file', $pathoToUpload, '', TRUE, $pathoToUpload.'thumbs/', $width, $height);
	
	//full path of the thumbnail image
	$thumb_src = base_url().'assest/uploads/thumbs/'.$upload_img;
	
	//set success and error messages
	$img = $upload_img ? $upload_img : false;
        
        echo $img;
        
        }
    }
    
    public function createProduct() {
        if($this->input->is_ajax_request()) {
           $return = $this->mainModel->insertProductInDB();
           
           if(is_array($return)) {
               echo json_encode(array(
                   'data' => $return
               ));
           } 
           else {
              echo $return;
           }
        }
        
    }
    
    
     public function updateProduct() {
        if($this->input->is_ajax_request()) {
           $return = $this->mainModel->updateProductInDB();
           
           if(is_array($return)) {
               echo json_encode(array(
                   'data' => $return
               ));
           } 
           else {
              echo $return;
           }
        }
        
    }
    
    
    public function editProduct($productId) {
        $data['product'] = $this->relation_product_model->
                with_pictures()->
                with_options()->
                get($productId);
   
        $data['allBrandsResult'] = $this->mainModel->getAllBrands();
        $data['allCategoriesResult'] = $this->mainModel->getAllCategories();
        $data['manualProducts'] = $this->mainModel->getManualProducts();
  
        
        $this->adminPage('admin/edit_product', $data);
    }
    
    public function updateNewest() {
        if($this->input->is_ajax_request()) {
            if($this->mainModel->updateNew()) {
                echo true;
            }
            else {
             echo false;
            }    
        }
    }
    

    public function addBrand() {
        $data['allBrandsResult'] = $this->mainModel->getAllBrands();
        $this->adminPage('admin/add_brand', $data);
    }
    
    public function deleteBrand() {
        if($this->input->is_ajax_request()) {
            echo $this->mainModel->deleteBrandById();
        }
    }
    
    public function deleteProduct() {
        if($this->input->is_ajax_request()) {
            echo $this->mainModel->deleteProductById();
        }
    }
    
    public function createBrand() {
        if($this->input->is_ajax_request()) {
            $brand = $this->mainModel->createBrand();
            
            if(!$brand) {
                echo false;
            }
            
            else {
                echo json_encode(array(
                    'brand_id' => $brand 
                ));
            }
        }
    }
    
    
    public function allProducts() {
        $data = $this->mainModel->getProducts();
        $this->adminPage('admin/all_products', $data);
    }
    
    public function searchProducts() {
        if($_GET) {
            $data = $this->mainModel->getProducts($_GET);
            $data['get'] = $_GET['product_name'];
            
            $this->adminPage('admin/all_products', $data);
        }
    }
    
    public function loadProducts() {
        if($this->input->is_ajax_request()) {
            $products = $this->mainModel->getProducts($this->input->post());
            
             echo json_encode($products);
        }
    }
}
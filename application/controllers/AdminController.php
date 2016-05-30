<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AdminController extends MyController {
     public function __construct() {
        parent::__construct();
        
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
        $this->adminPage('admin/index');
    }
    
    public function checkRole() {
       $this->permission('admin/productPage');
    }
    
    public function productPage() {
        $this->adminPage('admin/admin_page');
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
	
	$upload_img = $this->processUpload('file', $pathoToUpload, '', TRUE, $pathoToUpload.'thumbs/','200','160');
	
	//full path of the thumbnail image
	$thumb_src = base_url().'assest/uploads/thumbs/'.$upload_img;
	
	//set success and error messages
	$img = $upload_img ? $upload_img : false;
        
        echo $img;
        
        }
    }
    
    public function createProduct() {
        sleep(4);
        echo false;
    }

    
}
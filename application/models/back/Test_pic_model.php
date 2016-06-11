<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
class Test_pic_model extends MyModel
{
	public function __construct()
	{
        $this->table = 'pictures';
        $this->primary_key = 'id';
        
    	parent::__construct();
	}

}
/* End of file '/User_model.php' */
/* Location: ./application/models//User_model.php */
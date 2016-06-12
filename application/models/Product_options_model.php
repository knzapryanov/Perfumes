<?php

class Product_options_model extends MyModel
{
    
  public function __construct()
    {
        $this->table = 'product_options';
        $this->primary_key = 'id';
        
        parent::__construct();
    }
    
}

?>
<?php

class Product_options_model extends MyModel
{
    
//    public $table = 'pictures'; // you MUST mention the table name
//    public $primary_key = 'id'; // you MUST mention the primary key
//    public $fillable = array(); // If you want, you can set an array with the fields that can be filled by insert/update
//    public $protected = array(); // ...Or you can set an array with the fields that cannot be filled by insert/update
    public function __construct()
    {
        $this->table = 'product_options';
        $this->primary_key = 'id';
        
        parent::__construct();
    }
    
    
    
}

?>
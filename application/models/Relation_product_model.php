<?php

class Relation_product_model extends MyModel
{
//    public $table = 'products'; // you MUST mention the table name
//    public $primary_key = 'id'; // you MUST mention the primary key
//    public $fillable = array(); // If you want, you can set an array with the fields that can be filled by insert/update
//    public $protected = array(); // ...Or you can set an array with the fields that cannot be filled by insert/update
    public function __construct()
    {
        $this->table = 'products';
        $this->primary_key = 'id';
        
        $this->has_many['pictures'] = array(
            'foreign_model' => 'Pictures_model',
            'foreign_table' => 'pictures',
            'foreign_key'   => 'product_id',
            'local_key'     => 'id'
        );
        
        $this->has_many['options'] = array(
            'foreign_model' => 'Product_options_model',
            'foreign_table' => 'product_options',
            'foreign_key'   => 'product_id',
            'local_key'     => 'id'
        );

        
        
        parent::__construct();
    }

    // this is relation model
}

?>
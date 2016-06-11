<?php

class Migrate extends CI_Controller {
    
    public function doMigration($version = NULL) {
        
        if(isset($version) && ($this->migration->version($version) === FALSE)) {
            show_error($this->migration->error_string());
        }
        
        elseif(is_null($version) && ($this->migration->latest() === FALSE )) {
            show_error($this->migration->error_string());
        }
        
        else {
            echo 'migration success!';
        }
    }
} 

?>
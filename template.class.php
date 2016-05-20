<?php

class Template {
   public $template;
   
   function load($filepath) {
      $this->template = file_get_contents($filepath);
   }

   function replace($var, $content) {
      $this->template = str_replace("--$var--", $content, $this->template);
   }

   function publish() {
      eval("?>".$this->template."<?php ");
   }
}

?>
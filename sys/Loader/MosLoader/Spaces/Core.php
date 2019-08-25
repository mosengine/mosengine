<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Space::init($initus);
class Space {
    
    public static $autospaces = array();
    
    public static $spaces = array();
    
    public static $calcule = array();


    static public function init($initus)
    {
        include_once '../Inits/Library/connect.php';
        
        
        
    }

    static public function load($class, $dir)
    {
        $loader_dir = dirname(str_replace(basename(__FILE__), NULL, __FILE__)).DIRECTORY_SEPARATOR;
        
        $classes_dir        =      $loader_dir.'classes/Classes/';
        $classes_connector  =      $loader_dir.'classes/connector.php';
         

         
//         mkdir($classes_dir.$class);
//            $fp = fopen($classes_dir.$class.'/connector.php', 'w+');
//            fwrite($fp, '1');
//            fwrite($fp, '23');
//            fclose($fp);
        
    }
    
    static private function calculate()
    {
       $calculate_dir = dirname(str_replace(basename(__FILE__), NULL, __FILE__)).DIRECTORY_SEPARATOR;
       
    }


}







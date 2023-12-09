<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
namespace kernel;

    class Apps {
        
        
        static public function load($app_name) {
            
            $filename = apps_dir.$app_name.'.php';
            $dirname  = apps_dir.$app_name;
            
            if(is_file($filename))
            {
                if(is_dir($dirname)) { Core::newMessage('ERROR', ERROR_APPS_DIRNAME_AND_FILENAME); exit(); }
              
                include $filename;
              
            }
            elseif(is_dir($dirname))
            {
                $app_filename = $dirname.DIRECTORY_SEPARATOR.basename($dirname).'.php';
                
                include $app_filename;   
            }
            
        }

        
        
    }

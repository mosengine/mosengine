<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
namespace kernel;

    class Templates {
        
        static public $apps = array(); //TODO
        
        static public function initilization() {
            
            //Core::$settings['templates']['template'];
            
            
            Templates::load(template) ? Core::newMessage('DEBUG', LOAD_TEMPLATE.template) : $test = null ;
            
            
        }
        
        static public function load($template) {
            
            $template_name = basename(Router::$self_link, '.php');
            
            $filename = tpls_dir.template.DIRECTORY_SEPARATOR.$template_name.'.tpl';
            
            //include tpls_dir.template.DIRECTORY_SEPARATOR.$template_name.'.tpl';
            
            $lines = file($filename);

            foreach ($lines as $line_num => $line) {

                if(preg_match('/{{(\w+)_(\w+)}}/i', $line, $matches, PREG_OFFSET_CAPTURE))
                {
                    //ucfirst($filename);
                    
                    $app_name = mb_strtolower($matches[2][0]);
                    
                    $matches[1][0] == 'APP' ? Apps::load($app_name) : $test = NULL;
                }
                else
                {
                   echo $line; 
                }
                
                
                
            }
            
            return 1;
        }

        
        
    }

<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
namespace kernel;

    class Router {
        
        static public $self_host = NULL;
        static public $self_link = NULL;
        
        static public function initilization() {
            
            $actual_link = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            
            echo '<br><br>router start<br><br>';
            echo $actual_link.'<br><br>';
            //echo $_SERVER[ 'SERVER_PROTOCOL'];
            
            
            if($_SERVER['REQUEST_URI'] == "")
            {
                Router::$self_host = $_SERVER['HTTP_HOST'];
                Router::$self_link = $_SERVER['REQUEST_URI'];
                
                //echo self::$self_link;
            }
            
            
            $keywords = preg_split("/[\/]/", $_SERVER['REQUEST_URI']);
            
            print_r($keywords);
            
            Router::$self_host = $_SERVER['HTTP_HOST'];
            Router::$self_link = $_SERVER['REQUEST_URI'];
                
            
            
            foreach ($keywords as $value) {
               
            }
            
            //Core::newMessage('DEBUG', ROUTER_LOADED);
            
            return 1;
        }

        
        
    }

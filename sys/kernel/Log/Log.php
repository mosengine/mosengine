<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

namespace kernel;

    class Log {
        
        static public $messages = array();
        
        static public function newMessage($class, $message) {
            
            Log::$messages[$class] = $message;
            
            if(\kernel\Mos::$settings['kernel']['mode'] == 'Debug' && $class == 'DEBUG')
            {
                echo '<br>['.$class.']: '.$message;
            }
        }

        



        static public function test()
        {
            \kernel\Log::$messages[1] = '<br>first message<br>';
            echo 123;
        }
        
    }

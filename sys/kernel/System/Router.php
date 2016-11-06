<?php

/*
 * https://mosengine.org | MosEngine CMS | https://github.com/mosengine/mosengine
 */

namespace kernel\System;


class Router {
    
    
    public static function start()
    {
        $route = filter_input(INPUT_GET, 'route', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if($route != NULL)
        {
            
        }
        else
        {
            $default = \kernel\Mos::$config['DefaultTemplate'];
            
            echo '<br><br>'.$default.'<br><br>';
            
            echo \kernel\Handlers::Template($default);
            
            
        }
        
        \kernel\Client::info();
        
        
    }
    
    
}

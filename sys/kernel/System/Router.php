<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
            $default = \kernel\Mos::$setting['kernel']['DefaultTemplate'];
            
            echo \kernel\Handlers::Template($default);
            
            
        }
        
        
    }
}

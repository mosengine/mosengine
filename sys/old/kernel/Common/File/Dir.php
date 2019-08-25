<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace kernel\Common\File;


Class Dir 
{
    
    public static function create($path)
    {
        
        if(!is_dir($path))
        {
            mkdir($path);
        }
    }
    
    public static function delete($path)
    {
        rmdir($path);
        
    }
    
    
    
    
}

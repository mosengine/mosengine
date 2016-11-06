<?php

/*
 * https://mosengine.org | MosEngine CMS | https://github.com/mosengine/mosengine
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

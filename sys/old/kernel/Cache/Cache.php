<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cache
 *
 * @author Nelsson302
 */

namespace kernel;

class Cache {
    public static function create($filename, $text)
    {
        
        \kernel\Common\File::write($filename, $text);
        
    }
    
    public static function delete($filename)
    {
        \kernel\Common\File::delete($filename);
        
    }
    
    public static function cacheFileTime($cacheFile, $tplFile)
    {
        if(filemtime($tplFile) > filemtime($cacheFile))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public static function mkdir($dir)
    {
        $path = \kernel\Mos::$config['CacheDirectory'].$dir;
        
        \kernel\Common\File\Dir::create($path);
    }
}

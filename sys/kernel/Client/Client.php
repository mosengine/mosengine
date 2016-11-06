<?php

/*
 * https://mosengine.org | MosEngine CMS | https://github.com/mosengine/mosengine
 */

namespace kernel;

Class Client 
{
    
    static public function info()
    {
        $client_dir = \kernel\Mos::$config['HomeDirectory'].$_SERVER['REMOTE_ADDR'];
        
        
        \kernel\Common\File\Dir::create($client_dir);
        \kernel\Common\File::write($client_dir.'/Browser', $_SERVER['HTTP_USER_AGENT']);
        
        
    }
    
    
    
}

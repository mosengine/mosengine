<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Client
 *
 * @author Nelsson302
 */
namespace kernel;

class Client {
    
    static public function info()
    {
        $client_dir = \kernel\Mos::$setting['kernel']['HomeDirectory'].$_SERVER['REMOTE_ADDR'];
        
        
        \kernel\Common\File\Dir::create($client_dir);
        \kernel\Common\File::write($client_dir.'/Browser', $_SERVER['HTTP_USER_AGENT']);
        
        
    }
}

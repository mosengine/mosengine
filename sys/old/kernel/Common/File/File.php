<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of File
 *
 * @author Nelsson302
 */

namespace kernel\Common;
Class File
{
    static public function read($filename)
    {
        $lines = file($filename);
        
        $file = NULL;
        
        foreach ($lines as $line_num => $line) {
            $file .= $line;  
        }
        
        return $file;
    }
    
    static public function write($file, $write)
    {
        $fp = fopen($file, 'w+');
        fwrite($fp, $write);
        fclose($fp);
    }
    
    static public function delete($file)
    {
        unlink($file);
    }
    
}

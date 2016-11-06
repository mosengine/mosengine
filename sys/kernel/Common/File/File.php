<?php

/* 
 * https://mosengine.org | MosEngine CMS | https://github.com/mosengine/mosengine
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
<?php

/* 
 * https://mosengine.org | MosEngine CMS | https://github.com/mosengine/mosengine
 */

namespace kernel\System;

/* 
 * Проверка прав и туды сюды
 * 
 */

Class Charters
{

    static public function inspect($who)
    {
        
        if(preg_match('/(kernel)/i', $who))
        {
            
            if(is_callable($who))
            {
                $who = \kernel\Common\Classes::deconstruktClassname($who);
                $class = \kernel\Common\Classes::is_class($who);
                
                return TRUE;
            }
        }
        else
        {
                return FALSE;
        }

        



    }
}
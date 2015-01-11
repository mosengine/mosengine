<?php

/* 
 * https://mosengine.org | MosEngine CMS | https://github.com/mosengine/mosengine
 */

namespace kernel\System;

Class Message
{
    
    static public $logs = array();
    static private $date_operator, $names = array(), $magic_array = array();
    
    
    static public function set($class, $name, $message)
    {
        
        
        
        $now = date("YmdHis");
        $num = count(self::$names) + 1;
        
        self::valueToArray($class, $name, 'names', $num);
        self::valueToArray($class, $message, 'logs', $name, $now);
        
        
        
    }
    
    static public function sayhello()
    {
        echo 'hello!';
    }
    
    static private function valueToArray($class, $value, $arr, $key, $key2=NULL)
    {
        
        $array = self::$$arr;
        
        if(@array_key_exists($key, $array[$class]))
        {
            $key2 != NULL ? $array2 = $array[$class][$key][$key2] : $array2 = $array[$class][$key];
            
            is_array($array2) ? array_push($array2, $value) : $array2 = array('0' => $array2, '1' => $value);
            
            $key2 != NULL ? $array[$class][$key][$key2] = $array2 : $array[$class][$key] = $array2;
        }    
        else
        {
            $key2 == NULL ? $array[$class][$key] = $value : $array[$class][$key][$key2] = $value;
        }
        
        self::$$arr = $array;
        
    }

######################################################################################
#
# Функция получения debug сообщений, пока не нужна
#
######################################################################################
//    public function get($nameOrDate = NULL, $nOD2 = NULL)
//    {
//        if(self::isDate($nameOrDate))
//        {
//            define ("FIRST_IS_A_DATE", TRUE);
//            $nOD2 != NULL ? define ("SECOND_IS_A_NAME", TRUE) : define ("SECOND_IS_A_NULL", TRUE);
//        }
//        elseif(self::isDate($nOD2))
//        {
//            define ("SECOND_IS_A_DATE", TRUE);
//            $nameOrDate != NULL ? define ("FIRST_IS_A_NAME", TRUE) : define ("FIRST_IS_A_NULL", TRUE);
//        }
//        else
//        {
//            //Error
//        }
//        
//        FIRST_IS_A_DATE ? $date = self::getDate($nameOrDate) : $date = self::getDate($nOD2);
//        if(preg_match('/\|/i', $date)) 
//        {
//            $chars = preg_split('/\|/i', '123|321');
//            $date = $chars[0];
//            $date2 = $chars[1];
//        }
//        if(FIRST_IS_A_NULL or SECOND_IS_A_NULL)
//        {
//            foreach ($this->names as $key => $value) 
//            {
//                self::toMagicArray($value);
//            }
//        }
//        elseif(FIRST_IS_A_NAME or SECOND_IS_A_NAME)
//        {
//            FIRST_IS_A_NAME ? self::toMagicArray($nameOrDate) : self::toMagicArray($nOD2);
//        }
//        
//        ksort($this->magic_array);
//        foreach ($this->magic_array as $value)
//        {
//            $key = key($this->magic_array);
//            if($this->date_operator == 'less')
//            {
//                if($key > $date & $key < $date2 or $key > $date or $key < $date)
//                {
//                    return '['.$key.'] '.$value.'\n';
//                }
//            }
//            else
//            {
//                if($key < $date & $key > $date2 or $key < $date or $key > $date)
//                {
//                    return '['.$key.'] '.$value.'\n';
//                }
//            }
//        }
//        
//    }
//    
//    static private function isDate($check)
//    {
//        $count = mb_strlen($check,'UTF-8');
//        $sym = preg_match("/\d+/i", $check);
//        
//        if($count == 14 & $sym == TRUE)
//        {
//            return TRUE;
//        }
//        else
//        {
//            return FALSE;
//        }
//            
//    }
//    
//    static private function getDate($from)
//    {
//        if(preg_match("/<|>/i", $from))
//        {
//            if(preg_match("/(\w+|)(<|>)(\w+)/i", $from, $matches))
//            {
//               $matches[1] != NULL ? $date1 = $matches[1] : $date1 = NULL;
//               $matches[3] != NULL ? $date2 = $matches[3] : $date2 = NULL;
//               $matches[2] == '<' ? $this->date_operator = 'less' : $this->date_operator = 'more';
//               
//               if($date1 != NULL & $date2 != NULL)
//               {
//                   return $date1.'|'.$date2; 
//               }
//               elseif($date1 != NULL & $date2 == NULL)
//               {
//                   return $date1;
//               }
//               elseif($date1 == NULL & $date2 != NULL)
//               {
//                   return $date2;
//               }
//            }
//        }
//        else
//        {
//            return $from;
//        }
//    }
//    
//    static private function toMagicArray($name)
//    {
//        foreach ($this->logs[$name] as $value2)
//        {
//            $k = key($this->logs[$name]);
//
//            self::valueToArray($this->magic_array[$k], $value2);
//        }
//    }
    
}
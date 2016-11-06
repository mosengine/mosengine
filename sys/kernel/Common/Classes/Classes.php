<?php

namespace kernel\Common;

Class Classes {
    
   private static $keywords = array(); 
    
   public static function deconstruktClassname($classname)
   {
        $newclassname = preg_replace('/\\\/i', '/', $classname);

        $keywords = preg_split("/\//", $newclassname);

        foreach ($keywords as $key => $value) {
            self::$keywords[$classname]['max'] = $key;
            self::$keywords[$classname][$key] = $value;
        }

        return $newclassname;
   }
    
   public static function is_namespace($namespace)
   {
       self::deconstruktClassname($namespace);
   }
   
   public static function is_class($class)
   {
       self::deconstruktClassname($class);
       return self::$keywords[$class][2];
   }
   
   public static function is_function($func)
   {
       self::deconstruktClassname($func);
   }
   
}

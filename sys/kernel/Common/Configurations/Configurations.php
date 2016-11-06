<?php

/*
 * https://mosengine.org | MosEngine CMS | https://github.com/mosengine/mosengine
 */

/** ДОПИСАТЬ!!!
 * Обработка конфигурационных файлов ./confs
 * ??Соединить потом с System/Setting??
 *
 * TODO: Переделать Setting/Conf/KernelConf - соединить как-нибудь(скомпоновать)
 * ибо херня какая-то
 * 
 * @author nelsson302
 */
class Configurations {
    
    private static $vals = array();
    
    
    public function __construct() {
                
        
        
        
    }
    
    private static function skelet($file, $type, $masks=array())
    {
        
        $name = basename($file);
        
        if(is_file($file))
        {

            $lines = file($file);

            foreach ($lines as $line_num => $line) {

                foreach ($masks['masks'] as $key => $mask)
                {
                    if(preg_match($mask, $line, $matches, PREG_OFFSET_CAPTURE))
                    {
                        preg_match("/\w+=(,|(\w+,\w+))*/i", $matches[0][0]) ? 

                    }
                    
                }

            }

            return TRUE;

        }
        else
        {
         //   \kernel\System\Message::set('debug', 'loadclass', $setting_file." file doesn't exists");
        }
    }
    
    private static function load($name, $type)
    {
        
        
        
        
    }
    
    
}

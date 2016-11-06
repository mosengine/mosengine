<?php

/* 
 * https://mosengine.org | MosEngine CMS | https://github.com/mosengine/mosengine
 */

namespace kernel\System;

Class Setting
{
    
    static public $p = array();
    
    static public function load($setting_name)
    {

        
        $setting_file = \kernel\Mos::$config['SettingsDirectory'].$setting_name.'.setting';
        
        if(is_file($setting_file))
        {

            $lines = file($setting_file);

            foreach ($lines as $line_num => $line) {


                if(preg_match('/(\w+)\s*=\s*(\S+);/i', $line, $matches, PREG_OFFSET_CAPTURE))
                {
                    self::$p[$setting_name][$matches[1][0]] = $matches[2][0];

                }

            }

            return TRUE;

        }
        else
        {
         //   \kernel\System\Message::set('debug', 'loadclass', $setting_file." file doesn't exists");
        }






    }
}
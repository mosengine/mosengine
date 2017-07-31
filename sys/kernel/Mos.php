<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mos
 *
 * @author Nelsson302
 */

namespace kernel
{
    
    


    class Mos {

        
        static public $setting = array();
        static public $base = array();
        static public $sys_dir, $main_dir;
        
        static private $settinged;
        
        
        static public function loadSetting($setting_name=NULL)
        {
            if($setting_name == NULL)
            {
                $setting_name = 'kernel';
            }

            $filename = self::$sys_dir.'settings'.DIRECTORY_SEPARATOR.$setting_name.'.setting';

            if(is_file($filename))
            {

                $lines = file($filename);

                foreach ($lines as $line_num => $line) {

                    if(!isset($magic_dir))
                    {
                        $magic_dir = self::$main_dir;
                    }
                    elseif(preg_match('/(Directory)\\\\(\w+)/i', $line, $matches, PREG_OFFSET_CAPTURE))
                    {
                        if($matches[2][0] == 'Sys')
                        {
                            $magic_dir = self::$sys_dir;
                        }
                        elseif($matches[2][0] == 'Vars')
                        {
                            $magic_dir = self::$setting['kernel']['VarsDirectory'];
                        }

                    }

                    if(preg_match('/(\w+)\s*=\s*(\S+|);/i', $line, $matches, PREG_OFFSET_CAPTURE))
                    {
                       if(preg_match('/(Directory)/i', $matches[1][0], $qwerty, PREG_OFFSET_CAPTURE))
                       {
                            self::$setting[$setting_name][$matches[1][0]] = $magic_dir.$matches[2][0].DIRECTORY_SEPARATOR; 
                       }
                       else
                       {
                            self::$setting[$setting_name][$matches[1][0]] = $matches[2][0];
                       }
                    } 

                }
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        
        static public function loadLanguage($lang)
        {

            $filename = \kernel\Mos::$setting['kernel']['LangDirectory'].$lang;

            $lines = file($filename);

            foreach ($lines as $line_num => $line) {

                if(preg_match('/(\w+)\s*=([\s|\S+[\s|]*);/i', $line, $matches, PREG_OFFSET_CAPTURE))
                {
                    self::$base[$matches[1][0]] = $matches[2][0];


                } 
            }



        }
        
        static public function initilization($classname=NULL)
        {
            
            $sys_dir = dirname(str_replace(basename(__FILE__), NULL, __FILE__)).DIRECTORY_SEPARATOR;
            $main_dir = dirname($sys_dir).DIRECTORY_SEPARATOR;
            
            self::$sys_dir = $sys_dir;
            self::$main_dir = $main_dir;
            
            if($classname == NULL)
            {
                // Загрузка kernel.setting
                self::loadSetting();
                // Регистрация метода-обработчика автозагрузки классов
                spl_autoload_register(array('\kernel\Mos', 'initilization'));
                
                //Настройка кодировки
                mb_internal_encoding(self::$setting['kernel']['kernelEncode']);
                mb_regex_encoding(self::$setting['kernel']['kernelEncode']);
                mb_http_output(self::$setting['kernel']['kernelEncode']);

                //Загрузка языковой базы
                self::loadLanguage(self::$setting['kernel']['Language']);

                \kernel\System\Router::start();                
                
            }
            else
            {
                $basename = basename($classname);
                $fileOrDir = $sys_dir.$classname;
                
                
                if(self::loadSetting(strtolower($basename)))
                {
                    self::$settinged[$basename] = TRUE;
                }
                else
                {
                    self::$settinged[$basename] = FALSE;
                }

                if(is_file($fileOrDir.'.php'))
                {
                    include_once $fileOrDir.'.php';
                }
                elseif(is_dir($fileOrDir))
                {
                    include_once $fileOrDir.'\\'.$basename.'.php';
                }
                
                if(self::$settinged[$basename] == TRUE)
                {
                    \kernel\System\Message::set('debug', 'loadclass', $classname.self::$base['successfully_included_with'].__METHOD__."()");
                }
                else
                {

                    \kernel\System\Message::set('debug', 'loadclass', $classname.self::$base['successfully_included_without'].__METHOD__."()");
                }
                

            }


        }

    }
}
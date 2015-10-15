<?php

/* 
 * https://mosengine.org | MosEngine CMS | https://github.com/mosengine/mosengine
 */
namespace kernel
{
    use Exception,
        ErrorException;
    
    Class Mos
    {
            static private $included = array(), $classfiles = array(), $error_reporting, $keywords = array();
            
            static public $p = array();

            public function __construct() {
                
            }
            
            static public function activate($classname=NULL)
            {
                if($classname == NULL)
                {
                    self::loadSetting(__NAMESPACE__);
                    self::init();                    
                    self::$error_reporting = error_reporting();
                }
                else
                {
                    global $sys_dir;
                    
                    $classname = self::checkClassname($classname);

                    if(!self::getIncluded($classname))
                    {
                        $filename = basename($classname);
                        $filename = mb_strtolower($filename);
                        
                        self::loadSetting($filename) 
                                ? $ACTIVATED = TRUE & $INCLUDED = self::loadClass($classname)
                                : $ACTIVATED = FALSE;
                        
 
                        if($INCLUDED)
                        {
                            
                            if($ACTIVATED){ \kernel\System\Message::set('debug', 'loadclass', $classname.' successfully included with setting file '.self::loadSetting($filename, TRUE).' via '.__METHOD__."()");     } 
                            else         { \kernel\System\Message::set('debug', 'loadclass', $classname.' successfully included without setting file via '.__METHOD__."()"); }
                        } 
                        else 
                        {
                            \kernel\System\Message::set('debug', 'loadclass', $classname.' not included via '.__METHOD__."()"); 
                        }
                        
                        
                    }
                    else
                    {
                        //\kernel\System\Message::set('debug', 'loadclass', $classname.' successfully included and activated');
                    
                    }
                    
                }
                
            }
            
//           static private function error($errno, $errstr, $errfile, $errline)
//            {
//                if (!(self::$error_reporting & $errno))
//                {
//                    return false;
//                }
//                    
//                throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
//                
//            }
            
            static private function init()
            {
                //Подключение основных функции
                
                
                //Подключение системных функции
                
               
                
                // Регистрация метода-обработчика автозагрузки классов
                spl_autoload_register(array('\kernel\Mos', 'activate'));
                
                // Регистрация обработчика ошибок
                //set_error_handler(array('\kernel\Mos', 'error'));
                
                // Настройка кодировки
                mb_internal_encoding('UTF-8');
                mb_regex_encoding('UTF-8');
                mb_http_output('UTF-8');
                
            }
           
            
            static public function loadSetting($setting_name, $file=FALSE)
            {

                global $sys_dir;

                $setting_file = $sys_dir.'/settings/'.$setting_name.'.setting';

                if($file == TRUE)
                {
                    return $setting_file;
                }

                if(is_file($setting_file))
                {

                    $lines = file($setting_file);

                    foreach ($lines as $line_num => $line) {


                        if(preg_match('/(\w+)\s*=\s*(\w+);/i', $line, $matches, PREG_OFFSET_CAPTURE))
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
            
            static private function loadClass($classname)
            {
                global $sys_dir;
                
                $basename = '/'.basename($classname);
                $fileOrDir = $sys_dir.$classname;
                
                if(is_file($fileOrDir . '.php'))
                {
                    include_once $fileOrDir . '.php';
                    self::$included[$classname] = $fileOrDir . '.php';
                    
                    return TRUE;
                }
                elseif(is_dir($fileOrDir))
                {
                    include_once $fileOrDir.$basename . '.php';
                    self::$included[$classname] = $fileOrDir.$basename . '.php';
                    
                    return TRUE;
                }
                else
                {
                    return FALSE;
                }
            }
            
            
            static private function checkClassname($classname)
            {
                $classname = preg_replace('/\\\/i', '/', $classname);
               
                
                $keywords = preg_split("/\//", $classname);
                
                
                
                foreach ($keywords as $key => $value) {
                    
                    self::$keywords[$classname]['max'] = $key;
                    self::$keywords[$classname][$key] = $value;

                }
                
                
                return $classname;
                
            }
            
            

            public static function getIncluded($return)
            {
                return @self::$included[$return];
            }

            public static function getClassFiles()
            {
                return self::$classfiles;
            }
    }
}

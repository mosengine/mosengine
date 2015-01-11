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
            static private $included = array(), $classfiles = array(), $error_reporting;

            public function __construct() {
                
            }
            
            static public function activate($classname=NULL)
            {
                if($classname == NULL)
                {
                    self::init();
                    self::loadSetting();
                    self::$error_reporting = error_reporting();
                }
                else
                {
                    global $sys_dir;
                    
                    $classname = preg_replace('/\\\/i', '/', $classname);
                    
                    
                    
                    if(!self::getIncluded($classname))
                    {
//                        if(preg_match('/core\/Common/i', $classname) & !preg_match('/core\/Common\/Common/i', $classname))
//                            return \core\Common\Common::checkCommonClass($classname);

                        $filename = $sys_dir.$classname.'.php';
                        if(is_file($filename))
                        {
                            include_once $filename;
                            self::$included[$classname] = $classname;
                            $INCLUDED = TRUE;
                        } 
                        else 
                        { 
                            $INCLUDED= FALSE; 
                            
                        }
                        
                        $filename = basename($classname);
                        $filename = mb_strtolower($filename);
                        
                        if(self::getIncluded($classname))
                        {
                            \kernel\System\Setting::load($filename) ? $ACTIVATED = TRUE : $ACTIVATED = FALSE;
                        }
                        
                        
                        
                        if($INCLUDED)
                        {
                            if($ACTIVATED){ \kernel\System\Message::set('debug', 'loadclass', $classname.' successfully included and activated via '.__METHOD__."()");     } 
                            else         { \kernel\System\Message::set('debug', 'loadclass', $classname.' successfully included but not activated via '.__METHOD__."()"); }
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
                // Регистрация метода-обработчика автозагрузки классов
                spl_autoload_register(array('\kernel\Mos', 'activate'));
                
                // Регистрация обработчика ошибок
                //set_error_handler(array('\kernel\Mos', 'error'));
                
                // Настройка кодировки
                mb_internal_encoding('UTF-8');
                mb_regex_encoding('UTF-8');
                mb_http_output('UTF-8');
                
            }
            
            static private function loadSetting()
            {
                \kernel\System\Setting::load(__NAMESPACE__);
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

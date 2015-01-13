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
                    
                    
                    $classname = self::checkClassname($classname);
                    
                    
                    if(preg_match('/kernel\/Common[\w+]/i', $classname) & !preg_match('/kernel\/Common\/Common/i', $classname))
                           return self::loadCommon($classname);
                    
                    
                    
                    if(!self::getIncluded($classname))
                    {
                        $filename = $sys_dir.$classname.'.php';
                        
                        $basename = '/'.basename($classname);
                        
                        $filename2 = $sys_dir.$classname.$basename.'.php';
                        
                        if(is_file($filename))
                        {
                            include_once $filename;
                            self::$included[$classname] = $classname;
                            $INCLUDED = TRUE;
                        }
                        elseif(is_file($filename2))
                        {
                            include_once $filename2;
                            
                            echo $classname;
                            echo $classname.$basename;
                            
                            self::$included[$classname] = $classname;
                            
                            $filename = $filename2;
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
                            
                            if($ACTIVATED){ \kernel\System\Message::set('debug', 'loadclass', $classname.' successfully included with setting file '.\kernel\System\Setting::load($filename, TRUE).' via '.__METHOD__."()");     } 
                            else         { \kernel\System\Message::set('debug', 'loadclass', $classname.' successfully included without setting file via '.__METHOD__."()"); }
                        } 
                        else 
                        {
                            \kernel\System\Message::set('debug', 'loadclass', $classname.' not included via '.__METHOD__."()"); 
                        }
                        
                       // print_r(self::$included);
                        
                        
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
            
            static private function loadCommon($classname)
            {
                echo $classname;
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

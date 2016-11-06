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
            static private  $included = array(), 
                            $classfiles = array(),
                            
                            $error_reporting, $session,
                            $gets = array(), 
                            $keywords = array();
            
            static public   $config = array();
            
            public function __construct() {
                
            }

    //Публичные функции
            //Активация с параметром NULL активирует ядро
            static public function activate($classname=NULL)
            {
                if($classname == NULL)
                {
                    self::init();                    
                    self::$error_reporting = error_reporting();
                }
                else
                {
                    if(self::connect($classname))
                    {
                        $filename = mb_strtolower(self::$keywords[$classname][self::$keywords[$classname]['max']]);
                        
                    
                        \kernel\System\Setting::load($filename)
                        ? @\kernel\System\Message::set('debug', 'loadclass', $classname.' successfully included with setting file via '.__METHOD__."()")     
                        : @\kernel\System\Message::set('debug', 'loadclass', $classname.' successfully included without setting file via '.__METHOD__."()");
                        
                        
                    }
                    else
                    {
                        
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

            
            //Переделать в get
            private static function getIncluded($return)
            {
                return @self::$included[$return];
            }
            
            private static function connect($classname)
            {
                global $sys_dir;
                    
                    $classname = self::checkClassname($classname);
                    
                    if(!self::getIncluded($classname))
                    {
                        
                        $INCLUDED = self::loadClass($classname);
                        
                        if($INCLUDED)
                        {
                            return TRUE;
                        }
                        else
                        {
                            return FALSE;
                        }
          
                    } 
                    else 
                    {
                        return FALSE;
                    }
                        
                  
            }
            
    //Приватные функции
            //Инициализация ядра
            static private function init()
            {
                //Загрузка файла настроек и базы языка для kernel
                self::loadKernConfiguration();
                //loadKernLanguage();
                
                // Регистрация метода-обработчика автозагрузки классов
                spl_autoload_register(array('\kernel\Mos', 'activate'));
                
                // Регистрация обработчика ошибок
                //set_error_handler(array('\kernel\Mos', 'error'));
                
                // Настройка кодировки
                mb_internal_encoding(self::$config['kernelEncode']);
                mb_regex_encoding(self::$config['kernelEncode']);
                mb_http_output(self::$config['kernelEncode']);
                
            }
           
            //Альтернатива \kernel\System\Setting для kernel
            static private function loadKernConfiguration()
            {
                //Инициализация стартовых параметров
                global $main_dir, $sys_dir;
                
                self::$config['superdir']['main'] = $main_dir; 
                self::$config['superdir']['sys'] = $sys_dir;
                
                isset(self::$config['superdir']['main']) & isset(self::$config['superdir']['sys'])
                        ? $step = 2 : $step = 'error';
                
                
                //Подгрузка файла kernel.config
                if($step == 2)
                {
                    $magic_array = array();
                    
                    $thisdir = str_replace(basename(__FILE__), NULL, __FILE__);
                    
                    $config = $thisdir.'kernel.config';
                
                    $lines = file($config);

                    $i = 0;
                    
                    $session = NULL;
                    
                    foreach ($lines as $line_num => $line) {
                        //TODO реализовать подгрузку масок откуда нибудь из другого места(удобнее?)
                        
                        //
                        //ПЕРЕПИСАТЬ СЕСИИ ПРОСТО ПИЗДЕЦ ЧТО ЗА ХЕРНЯ!!!!!!
                        //
                        
                        //Открытие сессии присвоения вторичных параметров
                        //к инициализированым обычным параметрам
                        if(preg_match('/\[(\w+)\]/i', $line, $matches, PREG_OFFSET_CAPTURE))
                        {
                            if($session != NULL)
                            {
                                $session_old = $session;  
                            }
                                    
                            $session = $matches[1][0];
                        }
                        
                        //Закрытие сессии
                        if(preg_match('/\\[\/\/\]/i', $line, $matches, PREG_OFFSET_CAPTURE))
                        {

                            if(isset($session_old)) 
                            {
                                $session = $session_old;
                                unset($session_old);
                            }
                            else
                            {
                                unset($session);
                            }

                        }
                        
                        //Default значения 
                        if(preg_match('/\#\s+Default:\s+"(\S+)"/i', $line, $matches, PREG_OFFSET_CAPTURE))
                        {
                           if(preg_match('/\.\/(\S+)/i', $line, $matc, PREG_OFFSET_CAPTURE))
                           {
                                $default = $matc[1][0];
                           }
                           else
                           {
                                $default = $matches[1][0];
                           }
                        }
                         
                        //Инициализация параметров ядра
                        if(preg_match('/(\w+)\s*=\s*(\S+|);/i', $line, $matches, PREG_OFFSET_CAPTURE))
                        {
                            
                            if(!isset($matches[2][0]) or $matches[2][0] == NULL)
                            {
                                $matches[2][0] = $default;
                            }
                            
                            echo $matches[1][0]." = ".$matches[2][0].'def:'.$default.'<br>';
                            
                            if(preg_match('/\S+(Directory)[\S|\s]*/i', $matches[1][0], $dir, PREG_OFFSET_CAPTURE))
                            {
                                isset($session) ? self::$config[$matches[1][0]] = self::$config[$session].$matches[2][0].'/' : self::$config[$matches[1][0]] = self::$config['superdir']['main'].$matches[2][0].'/';
                            }
                            else
                            {
                                self::$config[$matches[1][0]] = $matches[2][0]; 
                            }
                        }
                    }
                    
                    
                }
                else
                {
                    exit();
                    return FALSE;
                }
                
                //Преобразование некоторых параметров kernel.config
                if ($step == 3)
                {

                        
                    
                    
                    
                    
                    
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
            
            //Преобразование названий классов
            static private function checkClassname($classname)
            {
                
                $new_classname = preg_replace('/\\\/i', '/', $classname);
               
                
                $keywords = preg_split("/\//", $new_classname);
                
                
                
                foreach ($keywords as $key => $value) {
                    
                    self::$keywords[$classname]['max'] = $key;
                    self::$keywords[$classname][$key] = $value;

                }
                
                
                return $new_classname;
                
            }
    }
}

<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

namespace kernel;

    class Core {
 
        static public $messages = array();
        static public $settings = array();
        
        static public $get_messages = NULL;
        
        static public function initilization($classname=NULL)
        {                            
            if($classname == NULL)
            {
                
                //Загрузка файлов .settings
                self::loadSetting('kernel');
                
                //Загрузка языковой базы
                self::loadLanguage(self::$settings['kernel']['language']);
                
                // Регистрация метода-обработчика автозагрузки классов
                spl_autoload_register(array('\kernel\Core', 'initilization'));
                
                Core::newMessage('DEBUG', SUCCESS_LOAD_KERNEL_STARTER);
        #        
        ########################################################################
        #
                
                //Router::start() ? Core::newMessage('DEBUG', ROUTER_SUCCESSFULLY) : Core::newMessage('DEBUG', ROUTER_START_ERROR);
                
                //Router::start();
               
                
                //echo self::$get_messages;
                
                //Настройка кодировки
                // mb_internal_encoding(self::$setting['kernel']['kernelEncode']);
                //   mb_regex_encoding(self::$setting['kernel']['kernelEncode']);
                //   mb_http_output(self::$setting['kernel']['kernelEncode']);         
                
                //set_error_handler(array('\kernel\Error', 'handler')); TODO?
            }
            else
            {
                
                
                $keywords = preg_split("/\\\/", $classname); //Имя класса в массив
                
                $filename = sys_dir.$keywords[0].DIRECTORY_SEPARATOR.end($keywords).DIRECTORY_SEPARATOR.end($keywords).'.php';      
                
                if(is_file($filename))
                {
                    //echo end($keywords);
                    
                    $settings_filename = mb_strtolower(end($keywords));
                    Core::loadSetting($settings_filename);

                    //echo @Core::$settings['templates']['template'];
                    
                    //Core::newMessage('DEBUG', LOADCLASS_CLASSNAME.' '.$classname.' '.VIA_FILENAME.' '.$filename );
                    Core::newMessage('DEBUG', LOADCLASS_CLASSNAME.' '.$classname);
                    
                    
                    
                    include $filename;
                }
            }
        
        
        }
        
        static public function loadSetting($setting)
        {                        
            $filename = settings_dir.$setting.'.setting';
            
            if(is_file($filename))
            {
                $lines = file($filename);

                foreach ($lines as $line_num => $line) {

                    if(preg_match('/(\w+)\s*=[\s|]*(\S+)[\s|]*;/i', $line, $matches, PREG_OFFSET_CAPTURE))
                    {
                        self::$settings[$setting][$matches[1][0]] = $matches[2][0];


                    } 

                }    
            }
        }
        
        static public function loadLanguage($language)
        {                        
            
            include languages_dir.$language.'/main.php';
            
          
        }
        
        static public function newMessage($class, $message) {
            
            self::$messages[$class] = $message;
            
            if(Core::$settings['kernel']['mode'] == 'Debug' && $class == 'DEBUG')
            {
                echo '<br>['.$class.']: '.$message;
                //self::$get_messages .= '<br>['.$class.']: '.$message;              //TODO Debug консоль
                
            }
            elseif($class == 'ERROR')
            {
                echo '<br>['.$class.']: '.$message;
            }
        }
        
    }
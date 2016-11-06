<?php

/*
 * https://mosengine.org | MosEngine CMS | https://github.com/mosengine/mosengine
 */
namespace kernel;

class Applications {
    
    static public $conf = array(), $template = array();
    
    static public function loadConfig($config_name)
    {
        $config_file = \kernel\Mos::$config['ConfDirectory'].$config_name.'.conf';
        
        echo '<br>'.$config_file.'<br>';
        
        if(is_file($config_file))
        {

            $lines = file($config_file);

            foreach ($lines as $line_num => $line) {


                if(preg_match('/(\w+)\s*=\s*(\S+);/i', $line, $matches, PREG_OFFSET_CAPTURE))
                {
                    self::$conf[$config_name][$matches[1][0]] = $matches[2][0];

                }

            }

            return TRUE;

        }
        else
        {
            exit('Ошибка загрузки конфигаЫ');
        }
    }
    
    
    
    static public function load($app_name, $return=NULL)
    {
        $app_file = \kernel\Mos::$config['AppDirectory'].$app_name;
        $app_format_file = '.php';
        
        if(is_file($app_file.$app_format_file))
        {
            $app_file = $app_file.$app_format_file;
            include_once $app_file;
        }
        elseif(is_dir($app_file))
        {
            $app_file = $app_file.'/'.basename($app_file).$app_format_file;
            include_once $app_file;
        }
        else
        {
            $app_file = NULL;
            exit('Error Applications');
        }
        
        
            
        if($return == TRUE)
        {
            return $app_file;
        }
                
    }
    
    static public function connector($app_connector, $return=NULL)
    {
        is_file($app_connector) ? include_once $app_connector : $app_connector = FALSE;
        
        if(is_file($app_connector))
        {
            $include = include $app_connector;
            return $include;
        }
        else
        {
            return FALSE;
        }
       
    }
    //Соединить с \kernel\Handlers::template
    // Два раза почему-то вызвается поправить.
    static public function template($app)
    {
        
        
        
        $tpl_file = \kernel\Mos::$config['TplDirectory'].\kernel\Mos::$config['DefaultTemplate'].'/'.$app.'.tpl';
        
        $cache_file = \kernel\Mos::$config['CacheDirectory'].'tpls/apps/'.$app;
        
        
        echo '<br>кэш-'.$cache_file;
        echo '<br>tpl-'.$tpl_file;
        
        if(is_file($cache_file))
        {
            echo 1;
            //Если время изменения файла шаблона больше файла кэша создаёт новый кэш
            if(\kernel\Cache::cacheFileTime($cache_file, $tpl_file))
            {
                \kernel\Cache::delete($cache_file);
                self::$template[$app] = \kernel\Common\File::read($cache_file);
                \kernel\Cache::create($cache_file, $template);
            }
            else
            {
                
                self::$template[$app] = \kernel\Common\File::read($cache_file);

            }

            

        }
        else
        {
            self::$template[$app] = NULL;
            $lines = file($tpl_file);

            foreach ($lines as $line_num => $line) 
            {
               self::$template[$app] .= $line;
            }

            \kernel\Cache::create($cache_file, self::$template[$app]);
            
        }
        
    }
            
    
    
}

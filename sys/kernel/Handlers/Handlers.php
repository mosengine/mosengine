<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Handlers
 *
 * @author Nelsson302
 */

namespace kernel;

class Handlers {
    static public $template = array();
    static public function Application($app, $return = NULL)
    {
        \kernel\Applications::loadConfig($app);
        \kernel\Applications::load($app, $return);
        
        $tpl_app = \kernel\Mos::$setting['kernel']['TplDirectory'].\kernel\Mos::$setting['kernel']['DefaultTemplate'].'/'.$app.'.tpl';
        
        if(is_file($tpl_app))
        {
          \kernel\Applications::template($app);
        }
        else
        {
            echo 'Not found'.$tpl_app;
        }
        
        
    }
    
    
    static public function Template($tpl, $param=NULL)
    {
        
        $dir = \kernel\Mos::$setting['kernel']['TplDirectory'];
        
        self::$template['connector'] = \kernel\Mos::$setting['kernel']['CacheDirectory'].'tpls/appconectors/'.$tpl.'_appconnector.php';
        self::$template['cacheFile'] = \kernel\Mos::$setting['kernel']['CacheDirectory'].'tpls/'.$tpl.'_index';
        self::$template['tplFile'] = $dir.$tpl.'/index.tpl';
        
            if(is_file(self::$template['cacheFile']))
            {
                
                //Если время изменения файла шаблона больше файла кэша создаёт новый кэш
                if(\kernel\Cache::cacheFileTime(\kernel\Handlers::$template['cacheFile'], \kernel\Handlers::$template['tplFile']))
                {
                    \kernel\Cache::delete(\kernel\Handlers::$template['cacheFile']);
                    $template = \kernel\Handlers::Template($tpl);
                    \kernel\Cache::create(\kernel\Handlers::$template['cacheFile'], $template);
                }
                else
                {
                    \kernel\Applications::connector(self::$template['connector']);
                    $template = \kernel\Common\File::read(self::$template['cacheFile']);
                    
                }
                
                
            }
            else
            {   
                $template = NULL; $connector= NULL;
                $lines = file(self::$template['tplFile']);
                foreach ($lines as $line_num => $line) {
                    //Преобразование путей шаблона(css, img, js)
                    if(preg_match('/<link href="(\S+)"(.+)/si', $line, $matches, PREG_OFFSET_CAPTURE))
                    {
                        $template .= "<link href='/tpls/".$tpl."/".$matches[1][0]."'".$matches[2][0];
                    }
                    elseif(preg_match('/(.+)src="(\S+)"(.+)/si', $line, $matches, PREG_OFFSET_CAPTURE))
                    {
                        preg_match("/http/i", $matches[2][0])
                                ? $template .= $matches[0][0]
                                : $template .= $matches[1][0]."src='/tpls/".$tpl."/".$matches[2][0]."'".$matches[3][0];
                    }
                    
                    
                    //Подключение приложений {{APP_(APP)}}
                    elseif(preg_match('/\{\{APP_(\w+)\}\}/i', $line, $matches, PREG_OFFSET_CAPTURE))
                    {
                        $app = strtolower($matches[1][0]);
                        
                        $app_tpl_file = \kernel\Mos::$setting['kernel']['TplDirectory'].$app.'.tpl';
                        
                        $connector .= '<?php  \kernel\Handlers::Application("'.$app.'"); ?>';
                        
                        \kernel\Handlers::Application($app);
                        
                        $template .= \kernel\Applications::$template[$app];
                        
                        
                    }
                    else
                    {
                        $template .= $line;
                    }
                }
                
                \kernel\Cache::create(self::$template['cacheFile'], $template);
                \kernel\Cache::create(self::$template['connector'], $connector);
            }
            
            return $template;
        
        }
        
    } 


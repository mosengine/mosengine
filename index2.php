<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

################################################################################
#
# Системный папки
#
#
####################

define('apps_dir', __DIR__.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR);
define('confs_dir', __DIR__.DIRECTORY_SEPARATOR.'confs'.DIRECTORY_SEPARATOR);
define('home_dir', __DIR__.DIRECTORY_SEPARATOR.'home'.DIRECTORY_SEPARATOR);
define('sys_dir', __DIR__.DIRECTORY_SEPARATOR.'sys'.DIRECTORY_SEPARATOR);
    define('cache_dir', sys_dir.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR);
    define('kernel_dir', sys_dir.DIRECTORY_SEPARATOR.'kernel'.DIRECTORY_SEPARATOR);
    define('languages_dir', sys_dir.DIRECTORY_SEPARATOR.'languages'.DIRECTORY_SEPARATOR);
    define('loader_dir', sys_dir.DIRECTORY_SEPARATOR.'loader'.DIRECTORY_SEPARATOR);
    define('settings_dir', sys_dir.DIRECTORY_SEPARATOR.'settings'.DIRECTORY_SEPARATOR);
define('tmp_dir', __DIR__.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR);
define('tpls_dir', __DIR__.DIRECTORY_SEPARATOR.'tpls'.DIRECTORY_SEPARATOR);


#####################
#
#
#
#
################################################################################
#
# Система
#
#
####################


require_once 'config.php';
require_once 'sys/kernel/Core.php';

kernel\Core::initilization();
kernel\Router::initilization();
kernel\Templates::initilization();



$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<br><br>Page generated in '.$total_time.' seconds.'."\n";
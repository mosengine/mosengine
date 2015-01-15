<?php

/* 
 * https://mosengine.org | MosEngine CMS | https://github.com/mosengine/mosengine
 */

// считываем текущее время
$start_time = microtime();

// разделяем секунды и миллисекунды (становятся значениями начальных ключей массива-списка)
$start_array = explode(" ",$start_time);

// это и есть стартовое время
$start_time = $start_array[1] + $start_array[0];
###################################################

error_reporting (E_ALL);

$main_dir = str_replace(basename(__FILE__), NULL, __FILE__);

// Константы:
define ('main_dir', $main_dir);
define ('DIRSEP', DIRECTORY_SEPARATOR);

//Подключение ядра
require_once main_dir . 'sys/mosengine.php';

echo \kernel\Common\Common::sayhello();

echo \kernel\Common\File::sayhello();


print_r(\kernel\System\Message::$logs['debug']);

###################################################
$end_time = microtime();

$end_array = explode(" ",$end_time);

$end_time = $end_array[1] + $end_array[0];

// вычитаем из конечного времени начальное
$time = $end_time - $start_time;

// выводим в выходной поток (броузер) время генерации страницы
printf("<br><br>Страница сгенерирована за %f секунд",$time);
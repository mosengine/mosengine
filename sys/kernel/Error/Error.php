<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
namespace kernel;

    class Error {
        
        static public function test()
        {
           echo '<br>kernel\Error\test';
        }
        
        static public function handler($errno, $errstr, $errfile, $errline)
        {
            echo 123;

            // может потребоваться экранирование $errstr:
            $errstr = htmlspecialchars($errstr);

            switch ($errno) {
            case E_USER_ERROR:
                echo "<b>Пользовательская ОШИБКА</b> [$errno] $errstr<br />\n";
                echo "  Фатальная ошибка в строке $errline файла $errfile";
                echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
                echo "Завершение работы...<br />\n";
                exit(1);

            case E_USER_WARNING:
                echo "<b>Пользовательское ПРЕДУПРЕЖДЕНИЕ</b> [$errno] $errstr<br />\n";
                break;

            case E_USER_NOTICE:
                echo "<b>Пользовательское УВЕДОМЛЕНИЕ</b> [$errno] $errstr<br />\n";
                break;

            default:
                echo "Неизвестная ошибка: [$errno] $errstr<br />\n";
                break;
            }

            /* Не запускаем внутренний обработчик ошибок PHP */
            return true;
        }
        
    }
<?php

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

require 'sys/kernel/Mos.php';

\kernel\Mos::initilization();

\kernel\Test::test();

print_r(\kernel\System\Message::$logs);


$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<br><br>Page generated in '.$total_time.' seconds.'."\n";
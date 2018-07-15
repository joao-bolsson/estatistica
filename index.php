<?php
/**
 * Index file to show the results.
 *
 * @author João Bolsson (jvmarques@inf.ufsm.br)
 * @since 2018, 14 Jul.
 */

require_once 'File.class.php';
require_once 'Math.class.php';

$array = File::readFile('ex1.csv');
$size = count($array);

$x = [];
$y = [];
$index = 0;
for ($i = 1; $i < $size; $i++) {
    $line = $array[$i];

    $n = count($line);
    for ($j = 0; $j < $n; $j++) {
        $x[$index] = $line[0];
        $y[$index] = $line[1];
        $index++;
    }

}


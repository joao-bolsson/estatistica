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
        $x[$index] = $line[0]; // propaganda
        $y[$index] = $line[1]; // retorno
        $index++;
    }

}

echo "=================<br>1) <br>";

$p = Math::coPearson($x, $y);
echo "p: " . $p . " -> " . Math::interpretaCoPearson($p) . "<br>";

echo "=================<br>2) <br>";

$b0 = Math::getB0($x, $y);
$b1 = Math::getB1($x, $y);

echo "b0: " . $b0 . " | b1: " . $b1 . "<br>";



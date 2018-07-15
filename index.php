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

// BANCO 1
echo "=================<br>1) <br>";

$math = new Math($x, $y);

$p = $math->coPearson();
echo "p: " . $p . " -> " . Math::interpretaCoPearson($p) . "<br>";

echo "=================<br>2) <br>";

$b0 = $math->getB0();
$b1 = $math->getB1();

$teste = $math->testeHipoteseRegressao();
echo "b0: " . $b0 . " | b1: " . $b1 . " | t0 (teste de hipotese): " . $teste . "<br>";

// BANCO 2
$array = File::readFile('ex2.csv');
$size = count($array);

$x = [];
$y = [];
$index = 0;
for ($i = 1; $i < $size; $i++) {
    $line = $array[$i];

    $n = count($line);
    for ($j = 0; $j < $n; $j++) {
        $x[$index] = $line[0]; // quilometragem
        $y[$index] = $line[1]; // litros
        $index++;
    }
}

$math = new Math($x, $y);

echo "=================<br>5) <br>";
$p = $math->coPearson();
echo "p: " . $p . " -> " . Math::interpretaCoPearson($p) . "<br>";
echo "sim, como ele tem correlaçao positiva, a medida que a quilometragem aumenta, a quantidade de combustível aumenta também";

echo "=================<br>6) <br>";

$b0 = $math->getB0();
$b1 = $math->getB1();

$teste = $math->testeHipoteseRegressao();
echo "b0: " . $b0 . " | b1: " . $b1 . " | t0 (teste de hipotese): " . $teste . "<br>";


<?php
/**
 * Class to calculate the results.
 *
 * @author João Bolsson (jvmarques@inf.ufsm.br)
 * @since 2018, 14 Jul.
 */

class Math {

    public static function coPearson(array $x, array $y): float {
        $Sxx = $Syy = $Sxy = 0.0;

        if (count($x) !== count($y)) {
            echo "BASE DE DADOS COM TAMANHO DIFERENTE";
            return 0; // erro
        }

        $n = count($x);

        // Sxx
        for ($i = 0; $i < $n; $i++) {
            $sum = 0;

            for ($j = 0; $j < $n; $j++) {
                $sum += floatval($x[$j]);
            }

            $Sxx += floatval(pow($x[$i], 2) - (pow($sum, 2) / $n));
        }

        // Syy
        for ($i = 0; $i < $n; $i++) {
            $sum = 0;

            for ($j = 0; $j < $n; $j++) {
                $sum += floatval($y[$j]);
            }

            $Syy += floatval(pow($y[$i], 2) - (pow($sum, 2) / $n));
        }

        // Sxy
        for ($i = 0; $i < $n; $i++) {
            $sumX = 0;
            $sumY = 0;
            for ($j = 0; $j < $n; $j++) {
                $sumX += floatval($x[$j]);
                $sumY += floatval($y[$j]);
            }

            $Sxy += floatval($x[$i] * $y[$i] - ($sumX * $sumY / $n));
        }

        // estimador
        $p = $Sxy / sqrt(floatval($Sxx * $Syy));

        return $p;
    }

}
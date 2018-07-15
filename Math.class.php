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
        $Sxx = self::getSxx($x);

        // Syy
        for ($i = 0; $i < $n; $i++) {
            $sum = 0;

            for ($j = 0; $j < $n; $j++) {
                $sum += floatval($y[$j]);
            }

            $Syy += floatval(pow($y[$i], 2) - (pow($sum, 2) / $n));
        }

        // Sxy
        $Sxy = self::getSxy($x, $y);

        // estimador
        $p = $Sxy / sqrt(floatval($Sxx * $Syy));

        return $p;
    }

    public static function getSxy(array $x, array $y): float {
        if (count($x) !== count($y)) {
            echo "BASE DE DADOS COM TAMANHO DIFERENTE";
            return 0; // erro
        }
        $Sxy = 0;
        $n = count($x);
        for ($i = 0; $i < $n; $i++) {
            $sumX = 0;
            $sumY = 0;
            for ($j = 0; $j < $n; $j++) {
                $sumX += floatval($x[$j]);
                $sumY += floatval($y[$j]);
            }

            $Sxy += floatval($x[$i] * $y[$i] - ($sumX * $sumY / $n));
        }
        return $Sxy;
    }

    public static function getSxx(array $x): float {
        $n = count($x);
        $Sxx = 0;
        for ($i = 0; $i < $n; $i++) {
            $sum = 0;

            for ($j = 0; $j < $n; $j++) {
                $sum += floatval($x[$j]);
            }

            $Sxx += floatval(pow($x[$i], 2) - (pow($sum, 2) / $n));
        }

        return $Sxx;
    }

    public static function testeHipoteseCorrelacao(float $p, int $n): float {
        $T0 = floatval($p * sqrt(floatval($n - 2)) / sqrt(floatval(1 - pow($p, 2))));

        return $T0;
    }

    public static function estimadorMinQuad(array $Y, array $x, int $index): float {
        if (count($Y) !== count($x)) {
            echo "ARRAYS COM TAMANHOS DIFERENTES";
            return 0; // erro
        }
        $medY = self::getMedia($Y);
        $medX = self::getMedia($x);

        $b1 = self::getB1($x, $Y);
        $b0 = $medY - $b1 * $medX;

        $uYI = floatval($b0 + $b1 * $x[$index]);

        return $uYI;
    }

    public static function getB1(array $x, array $Y): float {
        $b1 = self::getSxy($x, $Y) / self::getSxx($x);
        return $b1;
    }

    public static function getMedia(array $v): float {
        $med = 0;
        $n = count($v);
        for ($i = 0; $i < $n; $i++) {
            $med += floatval($v[$i]);
        }
        $med /= $n;

        return $med;
    }

    public static function getB0($x, $Y): float {
        $medY = self::getMedia($Y);
        $medX = self::getMedia($x);
        $b1 = self::getB1($x, $Y);
        $b0 = $medY - $b1 * $medX;

        return $b0;
    }

    public static function estimativaVariancia(array $x, array $y) {
        if (count($y) !== count($x)) {
            echo "ARRAYS COM TAMANHOS DIFERENTES";
            return 0; // erro
        }
        $n = count($x);

        $sum = 0;
        for ($i = 0; $i < $n; $i++) {
            $sum += floatval(pow($y[$i] - self::estimadorMinQuad($y, $x, $i), 2));
        }
        $est = (1 / ($n - 2)) * $sum;
        return $est;
    }

}
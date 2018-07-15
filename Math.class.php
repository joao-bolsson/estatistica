<?php
/**
 * Class to calculate the results.
 *
 * @author João Bolsson (jvmarques@inf.ufsm.br)
 * @since 2018, 14 Jul.
 */

class Math {

    private $Sxx, $Sxy, $Syy;
    private $x, $y;

    public function __construct(array $x, array $y) {
        $this->x = $x;
        $this->y = $y;
        // Sxx
        $this->Sxx = self::getSxx($x);

        // Syy
        $this->Syy = self::getSyy($y);

        // Sxy
        $this->Sxy = self::getSxy($x, $y);
    }

    public static function interpretaCoPearson(float $p): string {
        $s = "Correlação perfeita positiva";

        if ($p == -1) {
            $s = "Correlação perfeita negativa";
        } else if ($p > -1 && $p < 0) {
            $s = "Correlação negativa";
        } else if ($p == 0) {
            $s = "Correlação nula";
        } else if ($p > 0 && $p < 1) {
            $s = "Correlação positiva";
        }
        return $s;
    }

    public function coPearson(): float {
        // estimador
        $p = $this->Sxy / sqrt(floatval($this->Sxx * $this->Syy));

        return round($p, 2);
    }

    public static function getSyy(array $y): float {
        $Syy = 0;
        $n = count($y);
        for ($i = 0; $i < $n; $i++) {
            $sum = 0;

            for ($j = 0; $j < $n; $j++) {
                $sum += floatval($y[$j]);
            }

            $Syy += floatval(pow($y[$i], 2) - (pow($sum, 2) / $n));
        }

        return $Syy;
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

        return abs($T0);
    }

    public function estimadorMinQuad(int $index): float {
        $medY = self::getMedia($this->y);
        $medX = self::getMedia($this->x);

        $b1 = $this->getB1();
        $b0 = $medY - $b1 * $medX;

        $uYI = floatval($b0 + $b1 * $this->x[$index]);

        return $uYI;
    }

    public function getB1(): float {
        $b1 = $this->Sxy / $this->Sxx;
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

    public function getB0(): float {
        $medY = self::getMedia($this->y);
        $medX = self::getMedia($this->x);
        $b1 = $this->getB1();
        $b0 = $medY - $b1 * $medX;

        return $b0;
    }

    public function estimativaVariancia(): float {
        $n = count($this->x);

        $sum = 0;
        for ($i = 0; $i < $n; $i++) {
            $sum += floatval(pow($this->y[$i] - $this->estimadorMinQuad($i), 2));
        }
        $est = (1 / ($n - 2)) * $sum;
        return $est;
    }

    public function testeHipoteseRegressao(): float {
        $b1 = $this->getB1();
        $est = $this->estimativaVariancia();
        $t0 = $b1 / sqrt($est / $this->Sxx);
        return abs($t0);
    }

}
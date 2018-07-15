<?php
/**
 * Class to manage files.
 *
 * @author João Bolsson (jvmarques@inf.ufsm.br)
 * @since 2018, 14 Jul.
 */

class File {

    public static function readFile(string $name): array {
        $array = [];
        $i = 0;
        if (($handle = fopen($name, "r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                $array[$i] = $data;
                $i++;
            }
            fclose($handle);
        }

        return $array;
    }

}
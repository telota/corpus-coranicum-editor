<?php
/**
 * Created by PhpStorm.
 * User: suchmaske
 * Date: 26.07.16
 * Time: 10:36
 */

namespace App\Console\Commands\Helpers;

class CsvReader
{

    /**
     * Read CSV file and return associative array
     *
     * @param $file
     * @param $delimeter
     * @return array
     */
    public static function readCsv($file, $delimeter = "\t")
    {
        $lines = explode("\n", $file);
        $head = str_getcsv(array_shift($lines), $delimeter);

        $array = array();
        foreach ($lines as $line) {
            if (empty($line)) {
                continue;
            }

            $array[] = array_combine($head, str_getcsv($line, $delimeter));
        }

        return $array;
    }
}

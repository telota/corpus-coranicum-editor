<?php
/**
 * Created by PhpStorm.
 * User: suchmaske
 * Date: 05.10.17
 * Time: 09:18
 */

namespace App\Models\Helpers;

use Patchwork\Utf8;

/**
 * Class Transliterator
 * @package App\Models\Helpers
 */
class Transliterator
{

    /**
     * Normalize transliteration string
     *
     * @param $string
     * @return string
     */
    public static function transliterate($string)
    {

        // Patchwork/Utf8 can't handle ʾ and ʿ so they need to be replaced beforehand
        $normalizedApostrophies = str_replace(["ʾ", "ʿ"], "'", $string);

        // Return normalized string
        return Utf8::toAscii($normalizedApostrophies);
    }
}

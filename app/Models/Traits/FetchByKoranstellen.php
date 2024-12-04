<?php

namespace App\Models\Traits;

/**
 * Trait FetchByKoranstellen
 * @package App\Models\Traits
 */
trait FetchByKoranstellen
{


    /**
     * Get all items within a given sura
     *
     * @param $sure
     * @return mixed
     */
    public static function bySura($sure)
    {
        return self::where("sure", $sure)->get();
    }

    /**
     * Get all items within a given verse
     * @param $sure
     * @param $vers
     * @return mixed
     */
    public static function byVerse($sure, $vers)
    {
        return self::where("sure", $sure)
            ->where("vers", $vers)
            ->get();
    }

    /**
     * Get all items at a given word
     * @param $sure
     * @param $vers
     * @param $wort
     * @return
     */
    public static function byWord($sure, $vers, $wort)
    {
        return self::where("sure", $sure)
            ->where("vers", $vers)
            ->where("wort", $wort)
            ->get();
    }

    /**
     * Get all items in a given sura and all following suras.
     * @param $sure
     * @return mixed
     */
    public static function fromSura($sure)
    {
        return self::where("sure", ">=", $sure)
            ->get();
    }

    /**
     * Get all items in a given verse and all following verses
     * @param $sure
     * @param $vers
     * @return mixed
     */
    public static function fromVerse($sure, $vers)
    {
        $fromSura = self::fromSura(($sure + 1));

        $fromVerse = self::where("sure", $sure)
            ->where("vers", ">=", $vers)
            ->get();

        return $fromSura->merge($fromVerse);
    }

    /**
     * Get all items at a given word coordinate and all following words
     * @param $sure
     * @param $vers
     * @param $wort
     * @return mixed
     */
    public static function fromWord($sure, $vers, $wort)
    {
        $fromSura = self::fromSura(($sure + 1));

        $fromVerse = self::fromVerse($sure, ($vers + 1));

        $fromWort = self::where("sure", $sure)
            ->where("vers", $vers)
            ->where("wort", ">=", $wort)
            ->get();

        return $fromSura->merge($fromVerse)->merge($fromWort);
    }

    /**
     * Get all items within a given sura and all preceding suras
     * @param $sure
     * @return mixed
     */
    public static function toSura($sure)
    {
        return self::where("sure", "<=", $sure)->get();
    }

    /**
     * Get all items within a given verse and all preceding verses
     * @param $sure
     * @param $vers
     * @return mixed
     */
    public static function toVerse($sure, $vers)
    {
        $toSura = self::toSura(($sure - 1));

        $toVerse = self::where("sure", $sure)
            ->where("vers", "<=", $vers)
            ->get();

        return $toSura->merge($toVerse);
    }

    /**
     * Get all items at a given word coordinate and all preceding words
     * @param $sure
     * @param $vers
     * @param $wort
     * @return mixed
     */
    public static function toWord($sure, $vers, $wort)
    {
        $toSura = self::toSura(($sure - 1));

        $toVerse = self::toVerse($sure, ($vers - 1));

        $toWord = self::where("sure", $sure)
            ->where("vers", $vers)
            ->where("wort", "<=", $wort)
            ->get();

        return $toSura->merge($toVerse)->merge($toWord);
    }

    /**
     * Get all items between two given suras
     * @param $sureStart
     * @param $suraEnd
     * @return mixed
     */
    public static function betweenSuras($sureStart, $suraEnd)
    {
        $fromSura = self::fromSura($sureStart);

        $toSura = self::toSura($suraEnd);

        return $fromSura->intersect($toSura);
    }

    /**
     * Get all items between two given verses
     * @param $sureStart
     * @param $versStart
     * @param $sureEnde
     * @param $versEnde
     * @return mixed
     */
    public static function betweenVerses($sureStart, $versStart, $sureEnde, $versEnde)
    {
        $betweenSuras = self::betweenSuras(($sureStart + 1), ($sureEnde - 1));

        $startVerseRange = self::where("sure", $sureStart)
            ->where("vers", ">=", $versStart)
            ->get();

        $endVerseRange = self::where("sure", $sureEnde)
            ->where("vers", "<=", $versEnde)
            ->get();

        return $betweenSuras->merge($startVerseRange)->merge($endVerseRange);
    }

    /**
     * Get all items between two given word coordinates
     * @param $sureStart
     * @param $versStart
     * @param $wortStart
     * @param $sureEnde
     * @param $versEnde
     * @param $wortEnde
     * @return mixed
     */
    public static function betweenWords($sureStart, $versStart, $wortStart, $sureEnde, $versEnde, $wortEnde)
    {
        $betweenVerses = self::betweenVerses($sureStart, ($versStart + 1), $sureEnde, ($versEnde - 1));

        $startWordRange = self::where("sure", $sureStart)
            ->where("vers", $versStart)
            ->where("wort", ">=", $wortStart)
            ->get();

        $endWordRange = self::where("sure", $sureEnde)
            ->where("vers", $versEnde)
            ->where("wort", "<=", $wortEnde)
            ->get();

        return $betweenVerses->merge($startWordRange)->merge($endWordRange);
    }
}

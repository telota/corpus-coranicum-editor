<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Sure
 *
 * @mixin \Eloquent
 */
class Sure extends Model
{
    public $mekkaI = array(
        93, 94, 95, 97, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 111,
        81, 82, 84, 85, 86, 87, 88, 89, 90, 91, 92, 96,
        53, 74, 75, 77, 78, 79, 80,
        51, 52, 55, 56, 68, 69, 70, 73, 83
    );

    public $mekkaII = array(
        1, 54, 37, 15, 50, 20, 26, 76, 44, 71, 38, 36, 19, 18,
        17, 43, 72, 67, 23, 21, 25, 27
    );

    public $mekkaIII = array(
        32, 45, 30, 40, 29, 16, 41, 39, 11, 14, 12, 28, 31,
        42, 10, 34, 35, 7, 46, 6, 13
    );

    public $medinaSuren = array(
        2, 98, 64, 62, 8, 47, 3, 61, 57, 4, 65, 59, 33,
        63, 24, 58, 22, 48, 66, 60, 110, 49, 9, 5
    );


    /**
     * Get the maximum vers for a sura.
     * @param $sure
     * @return mixed
     */
    public static function getMaxVers($sure)
    {
        return
            DB::table('lc_kkoran')
            ->select('vers')
            ->where('sure', $sure)
            ->max('vers');
    }

    /**
     * Get the maximum word number of a given verse.
     * @param $sure
     * @param $vers
     * @return mixed
     */
    public static function getMaxWort($sure, $vers)
    {
        return
            DB::table("lc_kkoran")
            ->select('wort')
            ->where('sure', $sure)
            ->where('vers', $vers)
            ->max('wort');
    }

    /**
     * Get all maximum verses for each suras.
     *
     */
    public static function getMaxVerse()
    {
        $maxVerses = array();

        $maxVersesQuery = DB::table("lc_kkoran")
            ->select("sure", DB::raw("MAX(vers) as maxVers"))
            ->groupBy("sure")
            ->get();

        foreach ($maxVersesQuery as $m) {
            $maxVerses[$m->sure] = $m->maxVers;
        }

        return json_encode($maxVerses);
    }


    /**
     *
     */
    public static function getMaxWords()
    {
        $maxWords = array();

        $maxWordsQuery = DB::table("lc_kkoran")
            ->select("sure", "vers", DB::raw("MAX(wort) as maxWort"))
            ->where("vers", ">", 0)
            ->groupBy("sure", "vers")
            ->get();

        for ($sure = 1; $sure <= 114; $sure++) {
            $maxWords[$sure] = array();
        }

        foreach ($maxWordsQuery as $m) {
            $maxWords[$m->sure][$m->vers] = $m->maxWort;
        }

        return $maxWords;
    }

    public function getChronology($sure)
    {
        if (in_array($sure, $this->mekkaI)) {
            return "I";
        } elseif (in_array($sure, $this->mekkaII)) {
            return "II";
        } elseif (in_array($sure, $this->mekkaIII)) {
            return "III";
        } elseif (in_array($sure, $this->medinaSuren)) {
            return "IV";
        }

        return false;
    }
}

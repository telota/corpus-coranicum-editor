<?php

namespace App\Models;

use App\Models\Lesarten\Leseart;
use App\Models\Traits\ReadableKoranstellen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Telota\Rasmify;

/**
 * Class Koranstelle
 * @package App\Models
 */
class Koranstelle extends Model
{
    use ReadableKoranstellen;

    protected $table = "lc_kkoran";

    public $timestamps = false;

    protected $primaryKey = "index";

    protected $fillable = ["sure", "vers", "wort", "transcription","arab"];

    public static function getVerseCounts()
    {
        return Koranstelle::select('sure AS sura', DB::raw('MAX(vers) as max_verse'))->groupBy('sure')->get();
    }

    /**
     * Get rasm version of arabic word
     * @return string
     */
    public function getRasmAttribute()
    {
        return Rasmify::rasmify($this->attributes["arab"]);
    }

    /**
     * Get next vers
     * @param int $verseStart
     * @return bool
     */
    public function getNextVerse($verseStart = 1)
    {
        // Check if it is already max sure/vers
        if ($this->attributes["sure"] == 114 && $this->attributes["vers"] == Sure::getMaxVers(114)) {
            return false;
        }

        // Check if vers of sura is max vers of sura
        if ($this->attributes["vers"] >= Sure::getMaxVers($this->attributes["sure"])) {
            // Return first vers of next sura
            return Koranstelle::where("sure", "=", $this->attributes["sure"] + 1)
                ->where("vers", "=", $verseStart)
                ->first();
        }

        // Return the next vers
        return Koranstelle::where("sure", "=", $this->attributes["sure"])
            ->where("vers", "=", $this->attributes["vers"] + 1)
            ->first();
    }

    /**
     * Get next word relative to the current word
     * @param int $versStart
     * @return bool
     */
    public function getNextWord($versStart = 1)
    {
        // Check if it is already max sure/vers
        if ($this->attributes["sure"] == 114 &&
            $this->attributes["vers"] == Sure::getMaxVers(114) &&
            $this->attributes["wort"] == Sure::getMaxWort(114, Sure::getMaxVers(114))) {
            return false;
        }

        // Check if vers of sura is max vers of sura
        if ($this->attributes["vers"] == Sure::getMaxVers($this->attributes["sure"]) &&
            $this->attributes["wort"] == Sure::getMaxWort($this->attributes["sure"], $this->attributes["vers"])
        ) {
            // Return first word of next sura
            return Koranstelle::where("sure", "=", $this->attributes["sure"] + 1)
                ->where("vers", "=", $versStart)
                ->where("wort", ">=", 0)
                ->first();
        }

        // Check if word is the last word of the current verse
        if ($this->attributes["wort"] == Sure::getMaxWort($this->attributes["sure"], $this->attributes["vers"])) {
            // Return first word of next word
            return Koranstelle::where("sure", $this->attributes["sure"])
                ->where("vers", $this->attributes["vers"] + 1)
                ->where("wort", ">=", 0)
                ->first();
        }

        // If nothing else applies, get next word
        return Koranstelle::where("sure", $this->attributes["sure"])
            ->where("vers", $this->attributes["vers"])
            ->where("wort", $this->attributes["wort"] + 1)
            ->first();
    }

    /**
     * Get previous vers
     */
    public function getPrev()
    {
        // Check if it is already min sure/vers
        if ($this->attributes["sure"] == 1 && $this->attributes["vers"] == 1) {
            return false;
        }

        // Check if vers of sura is first vers of sura
        if ($this->attributes["vers"] == 1) {
            // Return max vers of previous sura
            return Koranstelle::where("sure", "=", $this->attributes["sure"] - 1)
                ->where("vers", "=", Sure::getMaxVers($this->attributes["sure"] - 1))
                ->first();
        }

        // Return the previous vers
        return Koranstelle::where("sure", "=", $this->attributes["sure"])
            ->where("vers", "=", $this->attributes["vers"] - 1)
            ->first();
    }

    /**
     * Transform Koranstelle into a coordinate
     */
    public function getCoordinateAttribute()
    {
        return
            str_pad($this->attributes["sure"], 3, 0, STR_PAD_LEFT) . ":" .
            str_pad($this->attributes["vers"], 3, 0, STR_PAD_LEFT) . ":" .
            str_pad($this->attributes["wort"], 3, 0, STR_PAD_LEFT);
    }

    /**
     * Compare two Textstellen to find out whether they are subsequent
     * @param $compSure
     * @param $compVers
     * @return bool
     */
    public function isNextOrEqualVerse($compSure, $compVers)
    {

        // Get correct next Textstelle
        $nextStelle = $this->getNextVerse();

        if (!$nextStelle) {
            return false;
        }

        // If the start of the next Textstelle is subsequent to the end of the current one,
        // or if both are equal, return true
        if (
            ($nextStelle->sure == $compSure && $nextStelle->vers == $compVers) ||
            ($this->attributes["sure"] == $compSure && $this->attributes["vers"] == $compVers)
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *  Compare two Textstellen to find out whether they are subsequent
     * @param $compsure
     * @param $compVers
     * @param $compWort
     * @return bool
     */
    public function isNextOrEqualWord($compSure, $compVers, $compWort = 0)
    {
        $nextWord = $this->getNextWord();

        if (!$nextWord) {
            return false;
        }

        if (($nextWord->sure == $compSure && $nextWord->vers == $compVers && $nextWord->wort == $compWort) ||
            (
                $this->attributes["sure"] == $compSure &&
                $this->attributes["vers"] == $compVers &&
                $this->attributes["wort"] == $compWort
            )
        ) {
            return true;
        }

        if ($this->attributes["wort"] == 0 && $compWort == 0) {
            return $this->isNextOrEqualVerse($compSure, $compVers);
        }

        return false;
    }

    /**
     * Get transliteration of a verse
     */
    public function getTransliteration()
    {

        // Get all words in a verse
        $words = Koranstelle::where("sure", $this->attributes["sure"])
            ->where("vers", $this->attributes["vers"])
            ->orderBy("wort")
            ->get();

        $transliteration = "";
        foreach ($words as $word) {
            $transliteration .= $word->transkription . " ";
        }

        return trim($transliteration);
    }

    public static function getVers($sure, $vers)
    {
        $words = Koranstelle::where("sure", $sure)
            ->where("vers", $vers)
            ->orderBy("wort")
            ->get();

        return $words;
    }

    /**
     * Get German Paret translation of a verse
     */
    public function getParet()
    {
        return Paret::where("sure", $this->attributes["sure"])
            ->where("vers", $this->attributes["vers"])
            ->first()
            ->text;
    }

    /**
     * Get all possible reading and textual variants for this text coordinate
     * @return \Illuminate\Support\Collection
     */
    public function getVariantenAttribute()
    {
        return $this->getAllVarianten();
    }

    /**
     * Parse all possible reading and textual variants for usage in select boxes
     * @return array|false
     */
    public function getVariantenForSelectAttribute()
    {
        $varianten = $this->varianten->toArray();

        array_push($varianten, "", "");

        return array_combine($varianten, $varianten);
    }


    /**
     * Get all Suras and Verses.
     * @return mixed
     */
    public static function getAllVerses()
    {
        return Koranstelle::select("sure", "vers")->groupBy("sure", "vers")->get();
    }

    /**
     * Get all words in the Qur'an, but no headers
     * @return mixed
     */
    public static function getAllWordsExceptHeaders()
    {
        return Koranstelle::select("*")
            ->where("vers", ">", 0)
            ->orderBy("sure", "asc")
            ->orderBy("vers", "asc")
            ->orderBy("wort", "asc")
            ->get();
    }

    /**
     * Get all words in the Qur'an, including its headers
     * @return mixed
     */
    public static function getAllWordsAndHeaders()
    {
        return Koranstelle::select("*")
            ->orderBy("sure", "asc")
            ->orderBy("vers", "asc")
            ->orderBy("wort", "asc")
            ->get();
    }

    /**
     * Get all words within a given sura, excluding the 0-verse
     * @param $sure
     * @return mixed
     */
    public static function getAllWordsBySura($sure)
    {
        return Koranstelle::select("*")
            ->where("vers", ">", 0)
            ->where("sure", $sure)
            ->orderBy("vers", "asc")
            ->orderBy("wort", "asc")
            ->get();
    }

    /**
     * Get all words within a given sura, including the 0-verse
     * @param $sure
     * @return mixed
     */
    public static function getAllWordsAndHeadersBySura($sure)
    {
        return Koranstelle::select("*")
            ->where("sure", $sure)
            ->orderBy("vers", "asc")
            ->orderBy("wort", "asc")
            ->get();
    }

    /**
     * Get the first verse for dropdown
     * @return array
     */
    public static function getFirstVersForDropdown()
    {
        $words = self::getVers(1, 1);

        $arab = array(0 => "");
        $transkription = array(0 => "");

        foreach ($words as $word) {
            $transkription[$word->wort] = "{$word->wort} ({$word->transkription})";
            $arab[$word->wort] = $word->arab;
        }

        $wordOptions = array("arab" => $arab, "transkription" => $transkription);

        return $wordOptions;
    }


    /**
     * Count words between two Textstellen
     * @param $otherTextstelle
     * @return int
     */
    public function getWordDistance($otherTextstelle)
    {
        $currentVers = Koranstelle::getVers($this->attributes["sure"], $this->attributes["vers"]);

        // If the Textstelle starts and ends in the same verse, return the word difference
        if (($currentVers->first()->sure == $otherTextstelle->sure &&
            $currentVers->first()->vers == $otherTextstelle->vers)) {
            return $otherTextstelle->wort - $this->attributes["wort"];
        }

        $startWordCount = $currentVers->count() - $this->attributes["wort"];

        $endWortCount = $otherTextstelle->wort;

        $distanceCounter = 0;

        $currentVers = $this->getNextVerse(0);

        while (!(($currentVers->sure == $otherTextstelle->sure) && ($currentVers->vers == $otherTextstelle->vers))) {
            $versWordCounter = Koranstelle::getVers($currentVers->sure, $currentVers->vers)->count();

            $distanceCounter += $versWordCounter;

            $currentVers = $currentVers->getNextVerse(0);
        }

        return $distanceCounter + $startWordCount + $endWortCount;
    }


    /**
     * Get all Koranstellen within a given range
     * @param $sureStart
     * @param $versStart
     * @param $wortStart
     * @param $sureEnde
     * @param $versEnde
     * @param $wortEnde
     * @return \Illuminate\Support\Collection
     */
    public static function getWordsWithinRange(
        $sureStart,
        $versStart,
        $wortStart = null,
        $sureEnde,
        $versEnde,
        $wortEnde = null
    ) {
        $koranstellen = array();

        if (!$wortStart && $versStart == 0) {
            $wortStart = 0;
        }

        if ($wortStart == null) {
            $wortStart = 1;
        }

        if (!$wortEnde) {
            $wortEnde = Koranstelle::getVers($sureEnde, $versEnde)->last()->wort;
        }

        $iterator = Koranstelle::where("sure", $sureStart)
            ->where("vers", $versStart)
            ->where("wort", $wortStart)
            ->first();

        // If no word could be found with a 0th word
        if ($iterator == null) {
            $iterator = Koranstelle::where("sure", $sureStart)
                ->where("vers", $versStart)
                ->where("wort", $wortStart + 1)
                ->first();
        }

        array_push($koranstellen, $iterator);


        $iterator = $iterator->getNextWord(0);

        // While the iterator is not the end-coordinate, process
        while (!(
            $iterator->sure == $sureEnde &&
            $iterator->vers == $versEnde &&
            $iterator->wort == $wortEnde
        )) {
            array_push($koranstellen, $iterator);

            if ($iterator->getNextWord(0) == null) {
                dd($iterator);
            }

            $iterator = $iterator->getNextWord(0);
        }

        // Add the last word, since the loop won't apply to it
        array_push($koranstellen, $iterator);

        return collect($koranstellen);
    }

    /**
     * Get Koranstelle for a given coordinate
     * @param $coordinate (001:001:001)
     * @return
     */
    public static function getKoranstelleFromCoordinate($coordinate)
    {

        // Coorindate must be of format 001:001:001
        $details = explode(":", $coordinate);

        if (sizeof($details) <= 2) {
            dd($details);
        }

        return Koranstelle::where("sure", intval($details[0]))
            ->where("vers", intval($details[1]))
            ->where("wort", intval($details[2]))
            ->first();
    }

    public static function getAllKoranstellenGrouped()
    {
        return Koranstelle::all()->groupBy("sure", "vers");
    }

    /**
     * @param $startCoordinate starting point
     * @param $numberOfWords defines how many words should be given
     * @return
     */
    public static function getNextNumberOfWords($startCoordinate, $numberOfWords)
    {
        $startingWord = self::getKoranstelleFromCoordinate($startCoordinate);
        $startID = $startingWord->index;

        return Koranstelle::select("*")
            ->where("index", ">=", $startID)
            ->where("index", "<", $startID+$numberOfWords)
            ->orderBy("index", "asc")
            ->get();
    }

    /**
     * Get the last text coordinate within a given verse
     * @param $sure
     * @param $vers
     * @return mixed
     */
    public static function getLastWordOfVers($sure, $vers)
    {
        return Koranstelle::select("*")
            ->where("sure", "=", $sure)
            ->where("vers", "=", $vers)
            ->orderBy("index", "desc")
            ->first();
    }

    public static function isLastWordOfVerse($sure, $vers, $wort)
    {
        $lastWord = Koranstelle::getLastWordOfVers($sure, $vers);

        return ($lastWord->word == $wort);
    }
}

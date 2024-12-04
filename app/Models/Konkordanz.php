<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Konkordanz
 *
 * @property int $location
 * @property int|null $suraverse
 * @property int|null $sure_cc
 * @property int|null $vers_cc
 * @property int|null $wort_cc
 * @property int|null $word_num
 * @property int|null $analyse
 * @property string|null $word
 * @property string|null $word_cc
 * @property string|null $base
 * @property string|null $base_cc
 * @property string|null $root
 * @property string|null $root_cc
 * @property string|null $prefix1
 * @property string|null $prefix1_part_of_speech
 * @property string|null $prefix1_semantic
 * @property string|null $prefix2
 * @property string|null $prefix2_part_of_speech
 * @property string|null $prefix2_semantic
 * @property string|null $prefix3
 * @property string|null $prefix3_part_of_speech
 * @property string|null $prefix3_semantic
 * @property string|null $part_of_speech
 * @property string|null $subcategory
 * @property string|null $semantic
 * @property string|null $semantic2
 * @property string|null $pattern
 * @property string|null $aspect
 * @property string|null $actpass
 * @property string|null $mortality
 * @property string|null $mood
 * @property string|null $prefix
 * @property string|null $gender
 * @property string|null $number
 * @property string|null $casefld
 * @property string|null $person
 * @property string|null $dependent_pron
 * @property string|null $dependent_person
 * @property string|null $dependent_number
 * @property string|null $dependent_gender
 * @property string|null $definite
 * @property string|null $diptotic
 * @property string|null $full_analyse
 * @property-read \App\Models\Koranstelle $koranstelle
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereActpass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereAnalyse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereAspect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereBaseCc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereCasefld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereDefinite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereDependentGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereDependentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereDependentPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereDependentPron($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereDiptotic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereFullAnalyse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereMood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereMortality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz wherePartOfSpeech($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz wherePattern($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz wherePerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz wherePrefix1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz wherePrefix1PartOfSpeech($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz wherePrefix1Semantic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz wherePrefix2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz wherePrefix2PartOfSpeech($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz wherePrefix2Semantic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz wherePrefix3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz wherePrefix3PartOfSpeech($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz wherePrefix3Semantic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereRoot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereRootCc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereSemantic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereSemantic2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereSubcategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereSuraverse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereSureCc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereVersCc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereWord($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereWordCc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereWordNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Konkordanz whereWortCc($value)
 * @mixin \Eloquent
 */
class Konkordanz extends Model
{
    protected $table = "qortbl2";

    protected $primaryKey = "location";

    public $timestamps = false;

    /**
     * Get corresponding text coordinate
     * @return mixed
     */
    public function koranstelle()
    {
        return $this->hasOne(Koranstelle::class, "sure", "sure_cc")
            ->where("vers", $this->vers_cc)
            ->where("wort", $this->wort_cc);
    }

    /**
     * Convert Rafi Talmon's transliteration to standard DMG
     * @param $rtkString
     * @return string
     */
    public static function rtkToDmg($rtkString)
    {
        $replacements = [
            "aa" => "ā",
            "ii" => "ī",
            "uu" => "ū",
            "&" => "ʿ",
            "H" => "ḥ",
            "'" => "ʾ",
            "(dh)" => "ḏ",
            "D" => "ḍ",
            "x" => "ḫ",
            "(sh)" => "š",
            "S" => "ṣ",
            "T" => "ṭ",
            "g" => "ġ",
            "j" => "ǧ",
            "(th)" => "ṯ",
            "b" => "b",
            "d" => "d",
            "h" => "h",
            "r" => "r",
            "t" => "t",
            "s" => "s",
            "w" => "w",
            "y" => "y",
            "a" => "a",
            "i" => "i",
            "m" => "m",
            "n" => "n",
            "k" => "k",
            "l" => "l",
            "f" => "f",
            "z" => "z",
            "q" => "q",
            "Z" => "ẓ"
        ];

        return strtr($rtkString, $replacements);
    }
}

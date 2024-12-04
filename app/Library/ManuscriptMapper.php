<?php

namespace App\Library;

use App\Models\Manuscripts\ManuscriptMapping;

class ManuscriptMapper
{

    private $suraToMaxVerse;

    public function __construct($suraToMaxVerse)
    {
        $this->suraToMaxVerse = $suraToMaxVerse;

    }

    private function versesAreContinuous($sura1, $verse1, $sura2, $verse2): bool
    {
        if ($sura1 == $sura2 && abs($verse1 - $verse2) <= 1) {
            return true;
        }

        if ($sura2 - $sura1 == 1) {
            return $verse1 == $this->suraToMaxVerse[$sura1] && $verse2 <= 1;
        }

        if ($sura1 - $sura2 == 1) {
            return $verse2 == $this->suraToMaxVerse[$sura2] && $verse1 <= 1;
        }

        return false;
    }

    public function makeMappings($mappings, $manuscriptId)
    {

        $limits = $mappings->sortBy(['sura_start', 'verse_start'])
            ->flatMap(function ($m) {
                return [
                    new VerseLimit(new Verse($m->sura_start, $m->verse_start), "start"),
                    new VerseLimit(new Verse($m->sura_end, $m->verse_end), "end"),

                ];
            });


        $current = new ManuscriptMapping();
        $current->manuscript_id = $manuscriptId;
        $mappings = [];

        foreach ($limits as $l) {
            if ($l->getLimit() == "end") {
                if (!isset($current->sura_end)) {
                    $current->sura_end = $l->getVerse()->getSura();
                    $current->verse_end = $l->getVerse()->getVerse();
                } else {
                    $currentEnd = new Verse($current->sura_end, $current->verse_end);
                    if ($currentEnd->isLessThan($l->getVerse())) {
                        $current->sura_end = $l->getVerse()->getSura();
                        $current->verse_end = $l->getVerse()->getVerse();

                    }

                }
            }
            if ($l->getLimit() == "start") {
                if (!isset($current->sura_start)) {
                    $current->sura_start = $l->getVerse()->getSura();
                    $current->verse_start = $l->getVerse()->getVerse();
                } elseif (isset($current->sura_end)) {
                    $currentEnd = new Verse($current->sura_end, $current->verse_end);
                    $isContinuous = $this->versesAreContinuous(
                        $current->sura_end,
                        $current->verse_end,
                        $l->getVerse()->getSura(),
                        $l->getVerse()->getVerse(),
                    );
                    if ($isContinuous) {
                        $current->sura_end = $l->getVerse()->getSura();
                        $current->verse_end = $l->getVerse()->getVerse();
                    } elseif ($currentEnd->isLessThan($l->getVerse())) {
                        $mappings[] = $current->toArray();
                        $current = new ManuscriptMapping();
                        $current->manuscript_id = $manuscriptId;
                        $current->sura_start = $l->getVerse()->getSura();
                        $current->verse_start = $l->getVerse()->getVerse();
                    }
                }

            }
        }

        if (isset($current->sura_end)) {
            $mappings[] = $current->toArray();

        }

        return $mappings;

    }


}
<?php

namespace App\Library;

class VerseLimit
{
    private Verse $verse;

    /**
     * @return Verse
     */
    public function getVerse(): Verse
    {
        return $this->verse;
    }

    /**
     * @return string
     */
    public function getLimit(): string
    {
        return $this->limit;
    }
    private string $limit;

    /**
     * @throws \Exception
     */
    public function __construct(Verse $verse, string $limit){
        $this->verse = $verse;

        if($limit !== "start" && $limit !== "end"){
            throw new \Exception('Only "start" or "end" permitted for a verse limit');
        }
        $this->limit = $limit;
    }

}
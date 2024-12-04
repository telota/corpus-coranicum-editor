<?php

namespace App\Library;

class Verse
{
    private int $sura;
    private int $verse;
    public function __construct(int $sura, int $verse){
        $this->sura = $sura;
        $this->verse = $verse;
    }

    /**
     * @return int
     */
    public function getSura(): int
    {
        return $this->sura;
    }

    /**
     * @return int
     */
    public function getVerse(): int
    {
        return $this->verse;
    }


    public function isEqualTo(Verse $verse): bool{
        return $this->sura == $verse->getSura() && $this->verse == $verse->getVerse();
    }

    public function isLessThan(Verse $verse): bool{
       if($this->sura < $verse->getSura()){
           return true;
       }
       if($this->sura == $verse->getSura()){
           return $this->verse < $verse->getVerse();
       }
       return false;
    }
}
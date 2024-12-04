<?php

use App\Models\Helpers\Transliterator;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TransliteratorTest extends TestCase
{

    /** @test */
    public function it_reduces_words_to_ascii()
    {

        $this->assertEquals("'anne", Transliterator::transliterate("ʾannē"));
        $this->assertEquals("al-mu'minina", Transliterator::transliterate("al-muʾminīna"));
        $this->assertEquals("ge'akum", Transliterator::transliterate("ǧēʾakum"));
        $this->assertEquals("l-hawae", Transliterator::transliterate("l-hawæ"));

        $this->assertEquals("s s d d a u i g h g h e ' ' _ z ae", Transliterator::transliterate("ṣ š ḏ ḍ ā ū ī ġ ḫ ǧ ḥ ē ʾ ʿ _ ẓ æ"));

    }

}

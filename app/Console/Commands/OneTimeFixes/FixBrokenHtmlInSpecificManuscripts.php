<?php

namespace App\Console\Commands\OneTimeFixes;

use App\Models\Manuskripte\Manuskript;
use App\Models\Manuskripte\Manuskriptseiten;
use App\Models\Manuskripte\ManuskriptseitenBild;
use Illuminate\Console\Command;

class FixBrokenHtmlInSpecificManuscripts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'fix:manuscript-html';
    /**
     * The console command description.
     *
     * @var string
     */
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        self::fix571();
        self::fix795();
        self::fix812();

    }

    public static function fix571()
    {
        $manuscript = Manuskript::findOrFail(571);

        $fixed = preg_replace("/enthält folgende Angaben:<\/p><br><\/p><p>/", "enthält folgende Angaben:</p><br><p>", $manuscript->Kommentar);

        $manuscript->Kommentar = $fixed;

        $manuscript->save();

    }

    public static function fix795()
    {
        $manuscript = Manuskript::findOrFail(795);

        $fixed = preg_replace("/werden unter der Signatur .*Arabe 341 b.* an der/",
            "werden unter der Signatur Arabe 341 b an der",
            $manuscript->Kommentar);

        $manuscript->Kommentar = $fixed;

        $manuscript->save();

    }

    public static function fix812()
    {
        $manuscript = Manuskript::findOrFail(812);

        $fixed = preg_replace(
            "/der Gothaer Signatur .*A 352.* zu einer Handschrift/",
            "der Gothaer Signatur A 352 zu einer Handschrift",
            $manuscript->Kommentar);

        $manuscript->Kommentar = $fixed;

        $manuscript->save();

    }


}

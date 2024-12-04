<?php

namespace App\Console\Commands;

use App\Models\Umwelttexte\Belegstelle;
use Illuminate\Console\Command;

class CleanUmwelttexteLanguages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'umwelttexte:clean-languages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up the language values in the umwelttexte and add rtl/ltr';

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


        $rtlLanguages = collect([
            "Altsüdarabisch",
            "Arabisch",
            "Aramäisch",
            "Aramäisch/Hebräisch",
            "Aramäisch (Palmyrenisch)",
            "Awestisch",
            "Awestisch/Altpersisch",
            "Hebräisch",
            "Mandäisch",
            "Mittelpersisch (Pahlavī)",
            "Syrisch",
        ]);

        $languageMappings = [
            "" => "",
            "Akkadisch"     => "Akkadisch",
            "Altarabisch"	=> "Arabisch",
            "Altäthiopisch (G&#601;&#703;&#601;z)" => "Altäthiopisch",
            "Altäthiopisch (Gəʿəz)" => "Altäthiopisch",
            "Altäthiopisch" => "Altäthiopisch",
            "Altavestisch" => "Awestisch/Altpersisch",
            "Alt-Avestisch" => "Awestisch/Altpersisch",
            "Altkirchenslawisch" => "Altkirchenslawisch",
            "Altpersisch/Awestisch" => "Awestisch/Altpersisch",
            "Altsüdarabisch" => "Altsüdarabisch",
            "Altsüdarabisch minäische Inschrift" => "Altsüdarabisch",
            "Arabisch" => "Arabisch",
            "Aramäisch" => "Aramäisch",
            "Aramäisch / Hebräisch" => "Aramäisch/Hebräisch",
            "Aramäisch/Hebräisch" => "Aramäisch/Hebräisch",
            "Aramäisch (Palmyrenisch)" => "Aramäisch (Palmyrenisch)",
            "Äthiopisch" => "Altäthiopisch",
            "Avestisch" => "Awestisch",
            "Awestisch" => "Awestisch",
            "Awestisch/Altpersisch" => "Awestisch/Altpersisch",
            "Griechisch" => "Griechisch",
            "Griechisch(?)" => "Griechisch",
            "Griechisch/Latein" => "Griechisch",
            "Griechisch/Syrisch" => "Griechisch",
            "Hebäisch" => "Hebräisch",
            "Hebräisch" => "Hebräisch",
            "Hebräisch / Aramäisch" => "Hebräisch",
            "Hebräisch / (Aramäisch)" => "Hebräisch",
            "Hebräisch/Aramäisch" => "Hebräisch",
            "Hebräisch/ Aramäisch" => "Hebräisch",
            "Hebräisch/(Aramäisch)" => "Hebräisch",
            "Jung-Avestisch" => "Awestisch/Altpersisch",
            "Koptisch" => "Koptisch",
            "Koptisch; Griechisch (nur fragmentarisch)" => "Koptisch",
            "Latein" => "Lateinisch",
            "Lateinisch" => "Lateinisch",
            "Lateinisch Mittelpersisch (Pahlavi)" => "Mittelpersisch (Pahlavī)",
            "Lateinisch (Original Griechisch)" => "Lateinisch",
            "Mandäisch" => "Mandäisch",
            "(Mittelpersisch) Pahlavī" => "Mittelpersisch (Pahlavī)",
            "Mittelpersisch (Pahlavī)" => "Mittelpersisch (Pahlavī)",
            "Palmyrenisch" => "Aramäisch (Palmyrenisch)",
            "Südarabisch" => "Altsüdarabisch",
            "Sumerisch" => "Sumerisch",
            "Syrisch" => "Syrisch"
        ];

        foreach(Belegstelle::all() as $umwelttext)
        {

            $umwelttext->Sprache = $languageMappings[trim($umwelttext->Sprache)];
            $umwelttext->save();

            if ($rtlLanguages->contains($umwelttext->Sprache))
            {
                $umwelttext->update(["Sprache_richtung" => "rtl"]);
            }

            else
            {
                $umwelttext->update(["Sprache_richtung" => "ltr"]);
            }

        }



    }
}

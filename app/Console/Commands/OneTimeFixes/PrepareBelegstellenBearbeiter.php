<?php

namespace App\Console\Commands\OneTimeFixes;

use App\Models\Umwelttexte\Belegstelle;
use App\Models\Umwelttexte\BelegstellenBearbeiter;
use Illuminate\Console\Command;

class PrepareBelegstellenBearbeiter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belegstellen:bearbeiter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export BelegstellenBearbeiter to separate table';

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
        foreach (Belegstelle::all() as $belegstelle) {
            $bearbeiter = $belegstelle->Bearbeiter;
            if (!$bearbeiter) {
                continue;
            }

            $zusatz = explode("(", $bearbeiter);
            $finalZusatz = "";
            if (count($zusatz) > 1) {
                $finalZusatz = trim("(" . $zusatz[1]);
                $bearbeiter = trim(str_replace($finalZusatz, "", $bearbeiter));
            }

            $bearbeiter = explode(",", $bearbeiter);

            foreach ($bearbeiter as $index => $b) {
                if (empty($b)) {
                    continue;
                }
                $editor = BelegstellenBearbeiter::firstOrNew([
                    "belegstelle" => $belegstelle->ID,
                    "bearbeiter" => trim($b)
                ]);
                if ($index == 0 && $finalZusatz) {
                    $editor->zusatz = $finalZusatz;
                }
                $editor->save();
            }

        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ChangeZoteroIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:change-zotero-ids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private function logOccurrencesWithContext($field, $haystack, $needle, $contextLength = 100): int
    {
        $offset = 0;
        $results = [];

        // Loop through the haystack to find all occurrences of the needle
        while (($pos = strpos($haystack, $needle, $offset)) !== false) {
            // Calculate the start of the context, ensuring it doesn't go below 0
            $start = max(0, $pos - $contextLength);

            // Calculate the length of the context
            $length = strlen($needle) + (2 * $contextLength);

            // Extract the context
            $context = substr($haystack, $start, $length);

            // Log the result
            $results[] = $context;

            // Move the offset forward to continue searching
            $offset = $pos + strlen($needle);
        }
        foreach ($results as $index => $context) {
            $this->info("Occurrence in field $field:" . $context);
        }
        return count($results);
    }


    private function changeId($old, $new)
    {
        foreach (Storage::disk('xml_files')->files('Kommentar') as $file) {
            $content = Storage::disk('xml_files')->get($file);
            $count = $this->logOccurrencesWithContext("XML Commentary", $content, $old, 50);
            if ($count > 0) {
                $updatedContent = str_replace($old, $new, $content);
                Storage::disk('xml_files')->put($file, $updatedContent);
            }
        }

        $columns = [
            "belegstellen" => [
                "Literatur",
                "Anmerkungen",
                "Anmerkungen_en",
                "Uebersetzer",
                "Bibeltext",
                "Edition",
                "Uebersetzung",
                "Identifikator",
                "HinweiseaufEdition",
                "Originalsprache",
                "Transkription",
                "Uebersetzung_dt",
                "Uebersetzung_en",
                "Uebersetzung_fr",
                "Uebersetzung_ar",
                "Autor"
            ],
            "kommentar" => [
                "bibliography_anmerkung",
                "bibliography_kommentar",
                "bibliography_literarkritik",
                "bibliography_textkritik",
                "bibliography_entwicklungsgeschichte",
                "bibliography_inhaltstruktur",
                "bibliography_situativitaet",
            ],
            "html_content" => [
                "en", "de", "fr"
            ],
            "translations" => [
                "en", "de", "fr", "ar", "fa", "tr", "ur", "ind", "ru"
            ],
            "ms_manuscript" => [
                "catalogue_entry",
                "commentary_internal",
                "codicology",
                "paleography",
                "ornaments"
            ]
        ];

        foreach ($columns as $table => $fields) {

            $query = DB::table($table);

            foreach ($fields as $field) {
                $query = $query->orWhere($field, 'like', "%$old%");
            }

            $results = $query->get();
            foreach ($results as $result) {
                if (property_exists($result, 'id')) {
                    $id_name = "id";
                } elseif (property_exists($result, 'ID')) {
                    $id_name = "ID";
                } elseif (property_exists($result, 'sure')) {
                    $id_name = "sure";
                }

                $this->info("Found element in table $table with id " . $result->$id_name);

                foreach ($fields as $field) {
                    $count = $this->logOccurrencesWithContext($field, $result->$field, $old, 50);
                    if ($count > 0) {
                        $newField = str_replace($old, $new, $result->$field);
                        DB::table($table)->where($id_name, $result->$id_name)->update([$field => $newField]);
                    }
                }
            }
        }

    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $idChanges = [
            "THVB26K2" => "322F85SA",
            "H6GJVIPB" => "NQGSWZUL",
            "246WHES3" => "AEFVBV8P",
            "Z833MEFS" => "TAN4DV2Q",
            "EK8KFUZR" => "CIXX9RPP",
            "UUA5VZSR" => "WR72G76S",
            "5XJHJQDH" => "DAJ38Q8B",
            "DJFNMCFE" => "9S76QVVE",
            "6HURHGRE" => "I2PQFWBB",
            "DEKDHVDJ" => "I2PQFWBB",
            "NXUX76GW" => "PWGCAS53",
            "WCNUUFAC" => "PWGCAS53",
            "VPMVPGH8" => "PTUZBGHT",
        ];

        foreach ($idChanges as $old => $new) {
            $this->changeId($old, $new);
        }


    }
}

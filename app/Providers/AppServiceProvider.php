<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Lesarten\Leseart;
use App\Models\Translation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

//        DB::listen(function ($query) {
//
//            // Log database queries that are longer than 100 milliseconds.
//
//                $queryDescription = '{'
//                    . 'time: '
//                    . $query->time
//                    . ', '
//                    . 'query:\"'
//                    . $query->sql
//                    . '\"'
//                    . '}';
//
//
//                Log::info($queryDescription, $query->bindings);
//        });
//
        // Extend Validation: make sure Textstellen end later than they start
        Validator::extend('textstellen_gt', function ($attribute, $value, $parameters, $validator) {
            // Get input data
            $data = $validator->getData();


            // Iterate over all Textstellen
            for ($i = 0; $i < sizeof($data["sura_start"]); $i++) {
                // Return false/invalid, if ending starting sura is greater than ending sura
                if ($data["sura_start"][$i] > $data["sura_end"][$i]) {
                    return false;
                }

                // Return false/invalid, if both suras are the same, but the starting verse
                // is greater than the ending verse
                if (
                    $data["sura_start"][$i] == $data["sura_end"][$i] &&
                    $data["verse_start"][$i] > $data["verse_end"][$i]
                ) {
                    return false;
                }

                // Only check for word placement, if word coordinates exist
                if (array_key_exists("word_start", $data)) {
                    // Return false/invalid, if the suras and verses are the same, but the
                    // starting word is greater than the ending word
                    if (
                        $data["sura_start"][$i] == $data["sura_end"][$i] &&
                        $data["verse_start"][$i] == $data["verse_end"][$i] &&
                        $data["word_start"][$i] > $data["word_end"][$i]
                    ) {
                        return false;
                    }
                }
            }

            // If the algorithm reaches this point, the validation was a success.
            return true;
        });

        /*
         * Check if the bildlink is a valid filename (doesn't contain slashes)
         */
        Validator::extend('valid_filename', function ($attribute, $value, $parameters, $validator) {
            $bildlink = $validator->getData()[$attribute];

            $bildfile = (strpos($attribute, "2") !== false) ? "Bildlink_file2" : "Bildlink_file";

            if (sizeof(explode("/", $bildlink)) > 1 && !empty($validator->getData()[$bildfile])) {
                return false;
            }

            return true;
        });

        /*
         * Check if the bildlink has a description
         */
        Validator::extend('bildlink_hasNachweis', function ($attribute, $value, $parameters, $validator) {
            $bildlink = $validator->getData()[$attribute];

            $nachweis = (strpos($attribute, "2") !== false) ? "Bildlink2nachweis" : "Bildlinknachweis";


            // Check if bildlink is empty
            if (!empty($bildlink)) {
                // Return false, if the image has no description
                if (empty($validator->getData()[$nachweis])) {
                    return false;
                }
            }
            return true;
        });

        /*
         * Make sure that there is at least one variant for Lesearten
         */
        Validator::extend('leseart_varianten', function ($attribute, $value, $parameters, $validator) {
            // Iterate over all varianten
            foreach ($value as $variante) {
                if (!empty($variante)) {
                    return true;
                }
            }
            return false;
        });

        /*
         * Make sure the leseart being created is new
         */
        Validator::extend('leseart_new', function ($attribute, $value, $parameters, $validator) {

            $data = $validator->getData();

            $quelle = $data["Quelle"];
            $leser = $data["Leser"];
            $sure = $data["sure"];
            $vers = $data["vers"];

            // Get all Lesearten for this sure and vers
            $currentLesearten = Leseart::where("sure", $sure)
                ->where("vers", $vers)
                ->where('quelle_id', $quelle)
                ->get();

            if (isset($currentLesearten)) {
                foreach ($currentLesearten as $current) {
                    foreach ($leser as $l) {
                        if ($current->leser->contains('id', $l)) {
                            return false;
                        }
                    }

                }
            }

            return true;
        });

        /*
         * Make sure the translation key doesn't appear twice
         */
        Validator::extend('translation_key', function ($attribute, $value, $parameters, $validator) {

            $data = $validator->getData();

            $key = $data["key"];

            $transformedKey = strtolower(trim(str_replace(" ", "_", $key)));

            // Count translation with same key;
            if (Translation::where("key", $transformedKey)->count()) {
                Session::flash("flash_type", "alert-danger");
                Session::flash("flash_message", "Key has been transformed to: " . $transformedKey);
                return false;
            }

            return true;
        });

        /*
         * Make sure the user input isn't empty html
         */
        Validator::extend('strip_tags_empty', function ($attribute, $value, $parameters, $validator) {
            if (empty(strip_tags($value))) {
                return false;
            }

            return true;
        });
        //
    }
}

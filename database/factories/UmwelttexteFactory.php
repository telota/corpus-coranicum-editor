<?php
/**
 * Created by PhpStorm.
 * User: suchmaske
 * Date: 03.04.18
 * Time: 16:32
 */

use App\Umwelttexte\Belegstelle;
use App\Umwelttexte\BelegstellenKategorie;

$factory->define(Belegstelle::class, function (Faker\Generator $faker) {
    return [
        "Titel" => $faker->words(3, true),
        "Sprache" => $faker->languageCode,
        "Sprache_richtung" => $faker->randomElement(["rtl", "ltr"]),
        "Ort" => $faker->city,
        "Datierung" => $faker->year,
        "Edition" => $faker->words(3, true),
        "Uebersetzung" => $faker->name,
        "Bearbeiter" => $faker->name,
        "Einstelldatum" => $faker->date(),
        "Originalsprache" => $faker->text,
        "Transkription" => $faker->text,
        "Uebersetzung_dt" => $faker->text,
        "Uebersetzung_en" => $faker->text,
        "Uebersetzung_fr" => $faker->text,
        "Uebersetzung_ar" => $faker->text,
        "Autor" => $faker->name,
        "allfields" => $faker->words(3, true),
        "webtauglich" => "ja",
        "Vermittlungssprache" => $faker->languageCode,
        "Literatur" => $faker->text,
        "kategorie" => $faker->randomElement(BelegstellenKategorie::all()->pluck("id")->toArray())
    ];
});
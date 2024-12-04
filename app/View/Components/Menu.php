<?php

namespace App\View\Components;

use App\Enums\Category;
use App\Http\Controllers\BelegstellenKategorieController;
use App\Http\Controllers\CCTranslationLanguageController;
use App\Http\Controllers\CollegiumCoranicumController;
use App\Http\Controllers\GlossarbelegController;
use App\Http\Controllers\GlossarController;
use App\Http\Controllers\HilfeController;
use App\Http\Controllers\KoranController;
use App\Http\Controllers\LeseartenController;
use App\Http\Controllers\LeserController;
use App\Http\Controllers\ManuscriptNewController;
use App\Http\Controllers\ManuscriptOriginalCodexController;
use App\Http\Controllers\ManuskriptController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\QuellenController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\UmwelttexteController;
use App\Http\Controllers\VeranstaltungController;
use App\Http\Controllers\ZoteroController;
use Illuminate\Support\Facades\URL;
use Illuminate\View\Component;

class Menu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */


    public array $fields;
    public string $type;

    public function __construct(string $type)
    {
        $this->type = $type;

        $translation = [
            "name" => "Translation",
            "label" => "translation",
            "options" => [
                [
                    "type"=>"list",
                    "name"=>"Html Content",
                    "link" => route('index', ['category'=>'html-content']),

                ],
                [
                    "type" => "list",
                    "name" => "Translations",
                    "link" => URL::action([TranslationController::class, 'index']),
                ],
                [
                    "type" => "add",
                    "name" => "New Translation Label",
                    "link" => URL::action([TranslationController::class, 'create']),
                ],
            ],
        ];

        $koran = [
            "name" => "Koran",
            "label" => "koran",
            "options" => [
                [
                    "type" => "list",
                    "name" => "Text nach Sure",
                    "link" => URL::action([KoranController::class, 'indexBySura'], 1),
                ]
            ]
        ];

        $manuscripts = [
            "name" => "Manuscripts",
            "label" => "manuscripts",
            "options" => [
                [
                    "type" => "list",
                    "name" => "Manuscripts",
                    "link" => URL::action([ManuscriptNewController::class, "index"]),
                ],
                [
                    "type" => "add",
                    "name" => "New Manuscript",
                    "link" => URL::action([ManuscriptNewController::class, "create"]),
                ],
                [
                    "type" => "list",
                    "name" => "Attributed To",
                    "link" => route('index', ['category'=>'attribution']),
                ],
                [
                    "type" => "list",
                    "name" => "Antiquity Markets",
                    "link" => route('index', ['category'=>Category::AntiquityMarket]),
                ],
                [
                    "type" => "list",
                    "name" => "Diacritics",
                    "link" => route('index', ['category'=>'diacritic']),
                ],
                [
                    "type" => "list",
                    "name" => "Funders",
                    "link" => route('index', ['category'=>'funder']),
                ],
                [
                    "type" => "list",
                    "name" => "Places",
                    "link" => route('index', ['category'=>Category::Place]),
                ],
                [
                    "type" => "list",
                    "name" => "Provenance",
                    "link" => route('index', ['category'=>'provenance']),
                ],
                [
                    "type" => "list",
                    "name" => "Reading Signs",
                    "link" => route('index', ['category'=>'reading-sign']),
                ],
                [
                    "type" => "list",
                    "name" => "Script Styles",
                    "link" => route('index', ['category'=>'script-style']),
                ],
                [
                    "type" => "list",
                    "name" => "Sister Leaves",
                    "link" => URL::action([ManuscriptOriginalCodexController::class, "index"]),
                ],
                [
                    "type" => "list",
                    "name" => "(Old Data Model) Manuscripts",
                    "link" => URL::action([ManuskriptController::class, "index"]),
                ],
            ]
        ];

        $lesarten = [
            "name" => "Lesarten",
            "label" => "lesarten",
            "options" => [
                [
                    "type" => "list",
                    "name" => "Übersicht",
                    "link" => URL::action([LeseartenController::class, "index"], 1),
                ],
                [
                    "type" => "list",
                    "name" => "Koranstellen/Kommentar",
                    "link" => URL::action([LeseartenController::class, "koranstellenIndex"], 1),
                ],
                [
                    "type" => "list",
                    "name" => "Leser",
                    "link" => URL::action([LeserController::class, "index"], 1),
                ],
                [
                    "type" => "list",
                    "name" => "Quellen",
                    "link" => route('index', ['category'=>\App\Enums\Category::Quelle]),
                ],
                [
                    "type" => "add",
                    "name" => "Neue Lesart",
                    "link" => URL::action([LeseartenController::class, "create"], 1),
                ],
            ]
        ];

        $intertexts = [
            "name" => "Intertexts",
            "label" => "intertexts",
            "options" => [
                [
                    "type" => "list",
                    "name" => "(Old Data Model) Intertexts",
                    "link" => URL::action([UmwelttexteController::class, "index"]),
                ],
                [
                    "type" => "add",
                    "name" => "New Intertext (Old Data Model)",
                    "link" => URL::action([UmwelttexteController::class, "create"]),
                ],
                [
                    "type" => "list",
                    "name" => "Umwelttextekategorien",
                    "link" => URL::action([BelegstellenKategorieController::class, "index"]),
                ],
            ]
        ];

        $glossary = [
            "name" => "Glossar",
            "label" => "glossary",
            "options" => [
                [
                    "type" => "list",
                    "name" => "Glossareinträge",
                    "link" => route('index', ['category'=>\App\Enums\Category::GlossaryEntry]),
                ],
                [
                    "type" => "add",
                    "name" => "Neuer Glossareintrag",
                    "link" => route('create', ['category'=>\App\Enums\Category::GlossaryEntry]),
                ],
                [
                    "type" => "list",
                    "name" => "Glossarbelege",
                    "link" => route('index', ['category'=>\App\Enums\Category::GlossaryEvidence]),
                ],
                [
                    "type" => "add",
                    "name" => "Neuer Glossarbeleg",
                    "link" => route('create', ['category'=>\App\Enums\Category::GlossaryEvidence]),
                ],
            ]
        ];

        $events = [
            "name" => "Veranstaltungen",
            "label" => "events",
            "options" => [
                [
                    "type" => "list",
                    "name" => "Veranstaltungen",
                    "link" => route('index', ['category'=>'veranstaltung']),
                ],
                [
                    "type" => "add",
                    "name" => "Neue Veranstaltung",
                    "link" => route('create', ['category'=>'veranstaltung']),
                ],
                [
                    "type" => "list",
                    "name" => "Collegia Coranica",
                    "link" => route('index', ['category'=>'collegium-coranicum']),
                ],
                [
                    "type" => "add",
                    "name" => "Neues Collegium Coranicum",
                    "link" => route('create', ['category'=>'collegium-coranicum']),
                ],
            ]
        ];

        $zotero = [
            "name" => "Zotero",
            "label" => "zotero",
            "options" => [
                [
                    "type" => "list",
                    "name" => "Overview",
                    "link" => URL::action([ZoteroController::class, "index"]),
                ],
            ]
        ];
        $hilfe = [
            "name" => "Hilfe",
            "label" => "hilfe",
            "options" => [
                [
                    "type" => "list",
                    "name" => "Oxygen Xml Einrichtung",
                    "link" => URL::action([HilfeController::class, "oxygenXml"]),
                ],
            ]
        ];

        $general = [
            "name" => "General",
            "label" => "general",
            "options" => [
                [
                    "type" => "list",
                    "name" => "Authors",
                    "link" => route('index', ['category'=>\App\Enums\Category::Author]),
                ],
            ]
        ];

        $this->fields = [
            $general,
            $manuscripts,
            $translation,
            $lesarten,
            $intertexts,
            $koran,
            $glossary,
            $events,
            $zotero,
            $hilfe
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menu', ["fields" => $this->fields]);
    }
}

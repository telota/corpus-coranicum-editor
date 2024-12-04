<?php

namespace App\Enums;

use App\Models\CollegiumCoranicum;
use App\Models\GeneralCC\CCAuthor;
use App\Models\Glossarbeleg;
use App\Models\Glossareintrag;
use App\Models\HtmlContent;
use App\Models\Lesarten\Quelle;
use App\Models\Manuscripts\Attribution;
use App\Models\Manuscripts\AntiquityMarket;
use App\Models\Manuscripts\Diacritic;
use App\Models\Manuscripts\Funder;
use App\Models\Manuscripts\ManuscriptNew;
use App\Models\Manuscripts\Place;
use App\Models\Manuscripts\Provenance;
use App\Models\Manuscripts\ReadingSign;
use App\Models\Manuscripts\ScriptStyle;
use App\Models\Veranstaltung;

enum Category: string
{
    case AntiquityMarket = 'antiquity-market';
    case Attribution = 'attribution';
    case Author = 'author';
    case CollegiumCoranicum = 'collegium-coranicum';
    case Diacritic = 'diacritic';
    case Funder = 'funder';
    case GlossaryEvidence = 'glossarbeleg';
    case GlossaryEntry = 'glossar';
    case HtmlContent = 'html-content';
    case Manuscript = 'manuscript';


    case Place = 'place';
    case Provenance = 'provenance';
    case Quelle = 'quelle';
    case ReadingSign = 'reading-sign';
    case ScriptStyle = 'script-style';
    case Veranstaltung = 'veranstaltung';


    public function indexTitle(): string
    {
        return match ($this) {
            Category::AntiquityMarket => 'Antiquity Markets',
            Category::Attribution => 'Attributions',
            Category::CollegiumCoranicum => 'Collegia Coranica',
            Category::Diacritic => 'Diacritics',
            Category::Funder => 'Funders',
            Category::GlossaryEntry => 'Glossarium',
            Category::GlossaryEvidence => 'Glossarbelege',
            Category::HtmlContent => 'HTML Content',
            Category::Manuscript => 'Manuscripts',
            Category::Author => 'Authors',
            Category::Place => 'Places',
            Category::Provenance => 'Provenances',
            Category::Quelle => 'Quellen',
            Category::ReadingSign => 'Reading Signs',
            Category::ScriptStyle => 'Script Styles',
            Category::Veranstaltung => 'Veranstaltungen',
        };
    }

    public function emptyTitle(): string
    {
        return match ($this) {
            Category::Author => 'CCAuthor',
            Category::AntiquityMarket => 'Antiquity Market',
            Category::Attribution => 'Attribution',
            Category::CollegiumCoranicum => 'Collegium Coranicum',
            Category::Diacritic => 'Diacritic',
            Category::Funder => 'Funder',
            Category::GlossaryEntry => 'Glossareintrag',
            Category::GlossaryEvidence => 'Glossarbeleg',
            Category::HtmlContent => 'HTML Content',
            Category::Manuscript => 'Manuscript',
            Category::Place => 'Place',
            Category::Provenance => 'Provenance',
            Category::Quelle => 'Quelle',
            Category::ReadingSign => 'Reading Sign',
            Category::ScriptStyle => 'Script Style',
            Category::Veranstaltung => 'Veranstaltung',
        };

    }

    public function singleTitle(): string
    {
        return match ($this) {
            Category::Author => 'author_name',
            Category::AntiquityMarket => 'antiquity_market',
            Category::Attribution => 'person',
            Category::CollegiumCoranicum => 'titel',
            Category::Diacritic => 'diacritic',
            Category::Funder => 'funder',
            Category::GlossaryEntry => 'wort',
            Category::GlossaryEvidence => 'belegstelle',
            Category::HtmlContent => 'label',
            Category::Manuscript => 'manuscript',
            Category::Place => 'place_name',
            Category::Provenance => 'provenance',
            Category::Quelle => 'anzeigetitel',
            Category::ReadingSign => 'reading_sign',
            Category::ScriptStyle => 'style',
            Category::Veranstaltung => 'titel',
        };

    }

    public function indexEntities()
    {
        return match ($this) {
            Category::AntiquityMarket => AntiquityMarket::all(),
            Category::Attribution => Attribution::all(),
            Category::Author => CCAuthor::with('roles.module')->get(),
            Category::CollegiumCoranicum => CollegiumCoranicum::all(),
            Category::Diacritic => Diacritic::all(),
            Category::Funder => Funder::all(),
            Category::HtmlContent => HtmlContent::all(),
            Category::GlossaryEntry => Glossareintrag::all(),
            Category::GlossaryEvidence => Glossarbeleg::all(),
            Category::Manuscript => ManuscriptNew::all(),
            Category::Place => Place::all(),
            Category::Provenance => Provenance::all(),
            Category::Quelle => Quelle::with('lesarten')->get(),
            Category::ReadingSign => ReadingSign::all(),
            Category::ScriptStyle => ScriptStyle::all(),
            Category::Veranstaltung => Veranstaltung::all(),
        };
    }

    public function indexColumns(): array
    {
        return match ($this) {
            Category::AntiquityMarket => ['Id', 'Antiquity Market'],
            Category::Attribution => ['Id', 'Name'],
            Category::Author => ['Id', 'Name', 'Variants Editor',
                'Variants Collaborator',
                'Variants Earlier Contributor',
                'Manuscript Metadata', 'Manuscript Transliteration', 'Manuscript Image', 'Manuscript Translation', 'Manuscript Assistance'],
            Category::CollegiumCoranicum => ['Id', 'Titel', 'Datum', 'Ort'],
            Category::Diacritic => ['Id', 'Diacritic'],
            Category::Funder => ['Id', 'Name'],
            Category::GlossaryEntry => ['Id', 'Wort', 'Wurzel', 'Belege', 'Literatur'],
            Category::GlossaryEvidence => ['Id', 'Wort', 'Wurzel', 'Typ', 'Belegstelle'],
            Category::HtmlContent => ['Label','de'],
            Category::Manuscript => ['Name', 'etc'],
            Category::Place => ['Id', 'Name', 'City', 'Country'],
            Category::Provenance => ['Id', 'Name'],
            Category::Quelle => ['Id', 'Anzeigetitel', 'Sigle', 'Lesarten'],
            Category::ReadingSign => ['Id', 'Sign'],
            Category::ScriptStyle => ['Id', 'Style'],
            Category::Veranstaltung => ['Id', 'Titel', 'Datum', 'Ort'],
        };
    }

    public function summaryRelations(): ?array
    {
        switch ($this) {
            case Category::AntiquityMarket:
            case Category::Attribution:
            case Category::Diacritic:
            case Category::Funder:
            case Category::Provenance:
            case Category::Place:
            case Category::ReadingSign:
            case Category::ScriptStyle:
                return [
                    "title" => Category::Manuscript->indexTitle(),
                    "columns" => ['Id', 'Name', 'Published'],
                    "rowComponent" => 'manuscript-summary',
                    "field" => 'manuscripts',
                ];
            case Category::GlossaryEntry:
                return [
                    "title" => Category::GlossaryEvidence->indexTitle(),
                    "columns" => ['Id', 'Typ', 'Belegstelle'],
                    "rowComponent" => "glossarbeleg-summary",
                    "field" => 'belege',
                ];
            case Category::Quelle:
                return [
                    "title" => "Reading Variants from this Source",
                    "id"=> "lesearten-table",
                    "addName" => "Reading Variant",
                    "addLink" => fn($id)=> route('lesearten.quellen.create', ['quelle'=>$id]),
                    "columns" => ['Id', 'Leser', 'Verse', 'Kanonisch'],
                    "rowComponent" => 'variants-source-summary',
                    "field" => "lesarten",
                ];

            default:
                return null;
        }
    }


    public function newEntity()
    {
        return match ($this) {
            Category::AntiquityMarket => new AntiquityMarket(),
            Category::Attribution => new Attribution(),
            Category::Author => new CCAuthor(),
            Category::CollegiumCoranicum => new CollegiumCoranicum(),
            Category::Diacritic => new Diacritic(),
            Category::Funder => new Funder(),
            Category::GlossaryEntry => new Glossareintrag(),
            Category::GlossaryEvidence => new Glossarbeleg(),
            Category::HtmlContent => new HtmlContent(),
            Category::Manuscript => new ManuscriptNew(),
            Category::Place => new Place(),
            Category::Provenance => new Provenance(),
            Category::Quelle => new Quelle(),
            Category::ReadingSign => new ReadingSign(),
            Category::ScriptStyle => new ScriptStyle(),
            Category::Veranstaltung => new Veranstaltung(),
        };
    }

    public function singleEntity($id)
    {
        return match ($this) {
            Category::AntiquityMarket => AntiquityMarket::findOrFail($id),
            Category::Attribution => Attribution::findOrFail($id),
            Category::Author => CCAuthor::findOrFail($id),
            Category::CollegiumCoranicum => CollegiumCoranicum::findOrFail($id),
            Category::Diacritic => Diacritic::findOrFail($id),
            Category::Funder => Funder::findOrFail($id),
            Category::GlossaryEntry => Glossareintrag::findOrFail($id),
            Category::GlossaryEvidence => Glossarbeleg::findOrFail($id),
            Category::HtmlContent => HtmlContent::findOrFail($id),
            Category::Manuscript => ManuscriptNew::findOrFail($id),
            Category::Place => Place::findOrFail($id),
            Category::Provenance => Provenance::findOrFail($id),
            Category::Quelle => Quelle::findOrFail($id),
            Category::ReadingSign => ReadingSign::findOrFail($id),
            Category::ScriptStyle => ScriptStyle::findOrFail($id),
            Category::Veranstaltung => Veranstaltung::findOrFail($id),
        };

    }

    public function addLink(): string
    {
        return route("create", ["category" => $this]);

    }

    public function editLink(): \Closure
    {
        return fn($id) => route('edit', ["category" => $this, "id" => $id]);

    }
}
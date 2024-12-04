# Paleocoran Data Base Description

## General

This document contains information about all the Paleocoran-revelant tables in the Corpus Coranicum data base.

---

## Relevant Tables

In alphabetical order:

* [aufbewahrungsorte](#aufbewahrungsorte)
* [image_details](#image_details)
* [lc_kkoran](#lc_kkoran)
* [manuskript](#manuskript)
* [manuskript_basic_readings_features](#manuskript_basic_readings_features)
* [manuskript_mapping](#manuskript_mapping)
* [manuskript_variant_reading_features](#manuskript_variant_reading_features)
* [manuskriptseiten](#manuskriptseiten)
* [manuskriptseiten_basic_readings_features](#manuskriptseiten_basic_readings_features)
* [manuskriptseiten_bilder](#manuskriptseiten_bilder)
* [manuskriptseiten_mapping](#manuskriptseiten_mapping)
* [manuskriptseiten_variant_orthography](#manuskriptseiten_variant_orthography)
* [manuskriptseiten_variant_orthography_features](#manuskriptseiten_variant_orthography_features)
* [manuskriptseiten_variant_readings](#manuskriptseiten_variant_readings)
* [manuskriptseiten_variant_readings_variants](#manuskriptseiten_variant_readings_variants)
* [manuskriptseiten_variant_readings_variants_features](#manuskriptseiten_variant_readings_variants_features)
* [manuskriptseiten_verse_separators](#manuskriptseiten_verse_separators)
* [paleocoran_codex_classifications](#paleocoran_codex_classifications)
* [paleocoran_codex_defects](#paleocoran_codex_defects)
* [paleocoran_codex_illumination](#paleocoran_codex_illumination)
* [paleocoran_codex_illumination_colors](#paleocoran_codex_illumination_colors)
* [paleocoran_codex_illumination_decorative_repertoire](#paleocoran_codex_illumination_decorative_repertoire)
* [paleocoran_codex_limit_lines](#paleocoran_codex_limit_lines)
* [paleocoran_codex_page_design_formula_agreement_of_aya](#paleocoran_codex_page_design_formula_agreement_of_aya)
* [paleocoran_codex_page_design_formula_chapter_designation](#paleocoran_codex_page_design_formula_chapter_designation)
* [paleocoran_codex_page_design_formula_sequence_of_numbering](#paleocoran_codex_page_design_formula_sequence_of_numbering)
* [paleocoran_codex_page_design_heading_type](#paleocoran_codex_page_design_heading_type)
* [paleocoran_codex_page_design_justification](#paleocoran_codex_page_design_justification)
* [paleocoran_codex_quire_composition](#paleocoran_codex_quire_composition)
* [paleocoran_codex_quire_types](#paleocoran_codex_quire_types)
* [paleocoran_codex_ruling_systems](#paleocoran_codex_ruling_systems)
* [paleocoran_codex_skins](#paleocoran_codex_skins)
* [paleocoran_manuscript_codex](#paleocoran_manuscript_codex)
* [paleocoran_manuscript_codex_manuscripts](#paleocoran_manuscript_codex_manuscripts)
* [paleocoran_manuscript_codex_mappings](#paleocoran_manuscript_codex_mappings)

---

## aufbewahrungsorte

#### Description

Information about places and instutitions holding the manuscripts referenced (see also [manuskript](#manuskript))

#### Model

`App\Manuskripte\Aufbewahrungsort`

### Fields

* `id` - incremental ID
* `ort` - name of the place (city)
* `country_code` - country code of the given location
* `name` - name of the holding institution
* `beschreibung` - description of the holding institution
* `link` - URL linking to the holding institution
* `bild_link` - irrelevant for Paleocoran
* `bild_link` - irrelevant for Paleocoran
* `bild_orig` - irrelevant for Paleocoran
* `bild_beschreibung` - irrelevant for Paleocoran

---

## image_details

#### Description

Annotations and snippets of images contained in [manuskriptseiten_bilder](#manuskriptseiten_bilder)

#### Model

`App\ImageDetail`

#### Fields

* `id` - incremental ID
* `created_at` - timestamp of creation
* `updated_at` - timestamp of last update
* `relation` - type of relation; currently the following values are allowed:
    - `manuskriptseiten_variant_readings` - i.e. this record contains an image annotation for [manuskriptseiten_variant_readings](#manuskriptseiten_variant_readings)
    - `manuskriptseiten_variant_orthography` - i.e. this record contains an image annotation for [manuskriptseiten_variant_orthography](#manuskriptseiten_variant_orthography)
    - `manuskriptseiten_verse_separators` - i.e. this record contains an image annotation for [manuskriptseiten_verse_separators](#manuskriptseiten_verse_separators)
* `relation_id` - ID of the given record, depending on the `relation` field
* `image_relation` - within Paleocoran, the value has to be `manuskript`
* `image_id` - ID of the given given manuscript image, see [manuskriptseiten_bilder](#manuskriptseiten_bilder)
* `title` - title of the given image annotation
* `description` - description of the image annotation
* `x` - relative horizontal offset of the original image in per cent (0..100)
* `y` - relative vertical offset of the original image in per cent (0..100)
* `width` - relative width of the selected sub-image in per cent (0..100)
* `height` - relative height of the selected sub-image in per cent (0..100)

---

## lc_kkoran

#### Description

All words in the Kairo version of the Qu'ran, identified by sura, verse and word coordinate

#### Model

`App\Modelsstelle`

#### Fields

* `index` - incremental ID
* `sure` - number of the sura
* `vers` - number of the verse in the given sura
* `wort` - number of the word in the given verse (in the given sura)
* `transkription` - latinized transcription of the given word
* `wurzel` - irrelevant
* `arab` - arabic representation of the given word

---

## manuskript

#### Description

Manuscripts, manuscript fragments, codicological units. A container of metadata describing a phyiscally existing Qur'an
manuscript. (This is not the reconstructed [paleocoran_manuscript_codex](#paleocoran_manuscript_codex)!)

#### Model

`App\Manuskripte\Manuskript`

#### Fields

* `ID` - incremental ID
* `Kodextitel` - name of the given manuscript
* `Format` - format information (width x height)
* `Aufbewahrungsort` - name of the holding institution of the given manuscript
* `AufbewahrungsortId` - foreign key to the holding institution (see `id` in [aufbewahrungsorte](#aufbewahrungsorte))
* `Signatur` - call number of the given manuscript in the holding institution
* `Herkunftsort` - place of origin
* `Datierung` - estimation when the given manuscript has been created
* `TextstelleKoran` - text ranges of the given in the Qur'an as a string. Computed from [manuskript_mapping](#manuskript_mapping)
* `Materialart` - material of the given manuscript (e.g. parchment, paper etc.)
* `Kodikologie` - free text comment about codicological information
* `Schriftduktus` - free text comment about calligraphy information
* `Palaographie` - free text comment about paleographical information
* `Textgliederung` - free text comment about text separation
* `Literatur` - references literature; bibliography
* `Bearbeiter` - names of colleagues who have edited the information of the given manuscript
* `Bild` - deprecated field
* `Kommentar_inter` - internal commentary, not to be shown to the public
* `Kommentar` - external commentary, to be shown to the public
* `webtauglich` - publish online. Three values are allowed:
    - `ja` - yes --> publish online
    - `ohneBild` - without image --> publish online but only show the metadata
    - `nein` - no --> don't publish online
* `remarks_additional_folio` - comment about additional folios (paleocoran)
* `remarks_foliation` - comment about foliation (paleocoran)
* `remarks_pagination` - comment about pagination (paleocoran)

---

## manuskript_basic_readings_features

#### Description

Management of features that occur in variant readings in associated manuscript pages 
(see [manuskriptseiten_variant_readings](#manuskriptseiten_variant_readings) and [manuskriptseiten](#manuskriptseiten))

#### Model

`App\Paleocoran\Manuskripte\ManuskriptseitenBasicReadingFeature`

#### Fields

* `id` - incremental ID 
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `manuskript_id` - ID of the referenced manuscript (`ID` in [manuskript](#manuskript))
* `feature` - name of the feature

---

## manuskript_mapping

#### Description

List of text ranges manuscripts range over, identified by starting and ending coordinate

#### Model

`App\Manuskripte\ManuskriptMapping`

#### Fields

* `id` - incrementing ID
* `manuskript` - ID of the referenced manuscript (`ID` in [manuskript](#manuskript))
* `sure_start` - number of the starting sura according to Kairo
* `vers_start` - number of the starting verse in the given sura according to Kairo
* `word_start` - number of the starting word  in the given verse according to Kairo
* `sure_ende` - number of the ending sura according to Kairo
* `vers_ende` - number of the ending verse in the given sura according to Kairo
* `wort_ende` - number of the ending word  in the given verse according to Kairo

---

## manuskript_variant_reading_features

#### Description

Aggregation of features that have been applied to [manuskriptseiten_variant_readings](#manuskriptseiten_variant_readings) 
and contextualization of what these features mean in the given manuscript.

#### Model

`App\Paleocoran\Manuskripte\ManuskriptVariantReadingFeature`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `manuskript_id` - ID of the referenced manuscript (`ID` in [manuskript](#manuskript))
* `feature` - name of the feature
* `definition` - description of what the feature means in the given manuscript

---

## manuskriptseiten

#### Description

Manuscript pages that are contained in a manuscript ([manuskript](#manuskript))

#### Model

`App\Manuskripte\Manuskriptseiten`

#### Fields

* `SeitenID` - incremental ID
* `ManuskriptID` - ID of the referenced manuscript (`ID` in [manuskript](#manuskript))
* `Bearbeiter` - name of last editor
* `Transkription` - deprecated field
* `Folio` - folio number of the current page
* `Seite` - page type (usually, `r` for *recto* or `v` for *verso*)
* `FolioundSeite` - computed field, consisting of `Folio` + `Seite` (e.g. fol. 1, page r => 1r)
* `Zeilenzahl` - Number of lines on the given page
* `Kommentar` - commentary for this page
* `Kommentar_intern` - commentary for the given page; don't show to the public
* `Palaeographie` - information about paleography
* `webtauglich` - publish online. Three values are allowed:
    - `ja` - yes --> publish online
    - `ohneBild` - without image --> publish online but only show the metadata
    - `nein` - no --> don't publish online
* `Format` - format information (width x height)
* `digilib` - deprecated

---

## manuskriptseiten_basic_readings_features

#### Description

Mapping of features for variant readings (see also [manuskriptseiten_variant_readings](#manuskriptseiten_variant_readings)).
A single variant reading can have multiple features

#### Model

`App\Paleocoran\Manuskriptseiten\ManuskriptseitenBasicReadingFeature`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `variant_reading_id` - reference to the variant reading (`id` in [manuskriptseiten_variant_readings](#manuskriptseiten_variant_readings))
* `feature` - name of the feature assigned to the variant reading

---

## manuskriptseiten_bilder

#### Description

Images associated with manuscript pages (see also [manuskriptseiten](#manuskriptseiten))

#### Model

`App\Manuskripte\ManuskriptseitenBild`

#### Fields

* `id` - incrementing ID
* `manuskriptseite` - reference to the manuscript page (`SeitenID` in Images associated with manuscript pages (see also [manuskriptseiten](#manuskriptseiten)))
* `Bildlink` - relative path to image on the image server
* `Bildlink_extern` - original URL, if available
* `Bildlinknachweis` - description of the image
* `webtauglich` - publish online. Three values are allowed:
      - `ja` - yes --> publish online
      - `ohneBild` - without image --> publish online but only show the metadata
      - `nein` - no --> don't publish online
* `created_at` - creation timestamp
* `updated_at` - update timestamp

---

## manuskriptseiten_mapping

#### Description

List of text ranges individual manuscript pages range over, identified by starting and ending coordinate

#### Model

`App\Manuskripte\ManuskriptseitenMapping`

#### Fields

* `id` - incrementing ID
* `manuskriptseite` - reference to the manuscript page (`SeitenID` in [manuskriptseiten](#manuskriptseiten))
* `sure_start` - number of the starting sura according to Kairo
* `vers_start` - number of the starting verse in the given sura according to Kairo
* `word_start` - number of the starting word  in the given verse according to Kairo
* `sure_ende` - number of the ending sura according to Kairo
* `vers_ende` - number of the ending verse in the given sura according to Kairo
* `wort_ende` - number of the ending word in the given verse according to Kairo

---

## manuskriptseiten_variant_orthography

#### Description

Variants in orthography (arabic scripture) recorded on a manuscript page, identified by their word coordinate

#### Model

`App\Paleocoran\Manuskriptseiten\ManuskriptseitenOrthographieVariante`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `manuskriptseiten_id` - reference to the manuscript page (`SeitenID` in [manuskriptseiten](#manuskriptseiten))
* `sure` - sura location in the text
* `vers` - verse location in the given sura
* `wort` - word location in the given verse
* `variant` - arabic string of how the given word is written in the given manuscript
* `comment` - free text comment about the given variant
* `lastUser` - ID of last editor

---

## manuskriptseiten_variant_orthography_features

#### Description

Associated features for the variants in orthography

#### Model

`App\Paleocoran\Manuskriptseiten\ManuskriptseitenOrthographieVariantenFeature`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `orthography_variant_id` - reference to the variant in orthography (`id` in [manuskriptseiten_variant_orthography](#manuskriptseiten_variant_orthography))
* `feature` - associated features for the given variant in orthography

---

## manuskriptseiten_variant_readings

#### Description

Variant readings (how the text was read aloud) recorded on manuscript pages, identified by their word coordinate

#### Model

`App\Paleocoran\Manuskriptseiten\ManuskriptseitenLesart`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `manuskriptseite_id` - reference to the manuscript page (`SeitenID` in [manuskriptseiten](#manuskriptseiten))
* `sure` - sura location in the text
* `vers` - verse location in the given sura
* `wort` - word location in the given verse
* `feature` - identifying feature of the given variant readings (e.g. red-dots)
* `comment` - free text comment about the given variant
* `lastUser` - ID of last editor

---

## manuskriptseiten_variant_readings_variants

#### Description

The actual variants of the variant readings, since there can be more than one way of reading a word aloud

#### Model

`App\Paleocoran\Manuskriptseiten\ManuskriptseitenLesartVariante`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `variant_reading_id` - reference to the parent variant reading (`id` in [manuskriptseiten_variant_readings](#manuskriptseiten_variant_readings))
* `variant` - transliteration of how the given word was read aloud (latinized)
* `normalized` - normalized version of the `variant` field, ASCII only

---

## manuskriptseiten_variant_readings_variants_features

#### Description

Particularities of single variant readings variants

#### Model

`App\Paleocoran\Manuskriptseiten\ManuskriptseitenVariantReadingVariantFeature`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `variant_id` - reference to the parent variant reading variant (`id` in [manuskriptseiten_variant_readings_variants](#manuskriptseiten_variant_readings_variants))
* `feature` - particularity for the referenced variant

---

## manuskriptseiten_verse_separators

#### Description

Verse separators recorded on manuscript pages, especially when their location differ from Kairo.
Identified by the word coordinate in the text

#### Model

`App\Paleocoran\Manuskriptseiten\ManuskriptseitenVerseSeparator`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `manuskriptseiten_id` - - reference to the manuscript page (`SeitenID` in [manuskriptseiten](#manuskriptseiten))
* `sure` - sura location in the text
* `vers` - verse location in the given sura
* `wort` - word location in the given verse
* `type` - category of the given verse separator
* `sure` - sura location in the text, in case it differs from Kairo
* `vers` - verse location in the given sura, in case it differs from Kairo
* `wort` - word location in the given verse, in case it differs from Kairo
* `comment` - free text comment about the given verse separator
* `description` - visual description of the given verse separator

---

## paleocoran_codex_classifications

#### Description

Classification of the reconstructed codices

#### Model

`App\Paleocoran\Codex\CodexClassification`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `paleocoran_manuscript_codex_id` - reference to the parent reconstructed manuscript codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))
* `supercategory` - first level classification type
* `subcategory` - second level classification type

---

## paleocoran_codex_defects

#### Description

Defects recorded in reconstructed codices

#### Model

`App\Paleocoran\Codex\CodexDefect`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `paleocoran_manuscript_codex_id` - reference to the parent reconstructed manuscript codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))
* `defect` - defect in the given codex

---

## paleocoran_codex_illumination

#### Description

Illuminations recorded in a reconstructed codex

#### Model

`App\Paleocoran\Codex\CodexIllumination`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `illumination_type` - type of illumination
* `manuskriptseiten_id` - reference to the manuscript page (`SeitenID` in [manuskriptseiten](#manuskriptseiten))
* `paleocoran_manuscript_codex_id` - reference to the parent reconstructed manuscript codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))

---

## paleocoran_codex_illumination_colors

#### Description

Colors used in the codex illuminations

#### Model

`App\Paleocoran\Codex\CodexIlluminationColor`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `paleocoran_manuscript_codex_id` - reference to the parent reconstructed manuscript codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))
* `color` - color used in the given manuscript codex

---

## paleocoran_codex_illumination_decorative_repertoire

#### Description

Decorations used in the reconstructed codices and their illuminations

#### Model

`App\Paleocoran\Codex\CodexIlluminationDecoration`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `paleocoran_manuscript_codex_id` - reference to the parent reconstructed manuscript codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))
* `decoration` - decoration used in the given manuscript codex

---

## paleocoran_codex_limit_lines

#### Description

Limit lines used in the reconstructed codices

#### Model

`App\Paleocoran\Codex\CodexIlluminationDecoration`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `paleocoran_manuscript_codex_id` - reference to the parent reconstructed manuscript codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))
* `limit_lines` - limiting lines used in the given manuscript codex

---

## paleocoran_codex_page_design_formula_agreement_of_aya

#### Description

Agreements of aya used in the page design in the reconstructed codices

#### Model

`App\Paleocoran\Codex\CodexAgreementOfAya`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `paleocoran_manuscript_codex_id` - reference to the parent reconstructed manuscript codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))
* `agreement_of_aya` - agreement of aya used in the given reconstructed codex

---

## paleocoran_codex_page_design_formula_chapter_designation

#### Description

Chapter designations used in the page design in the reconstructed codices

#### Model

`App\Paleocoran\Codex\CodexChapterDesignation`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `paleocoran_manuscript_codex_id` - reference to the parent reconstructed manuscript codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))
* `designation` - designations used in the reconstructed codex

---

## paleocoran_codex_page_design_formula_sequence_of_numbering

#### Description

Sequence of numbering used in reconstructed codices

#### Model

`App\Paleocoran\Codex\CodexSequenceOfNumbering`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `paleocoran_manuscript_codex_id` - reference to the parent reconstructed manuscript codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))
* `sequence` - type of sequence

---

## paleocoran_codex_page_design_heading_type

#### Description

Heading types used in reconstructed codices

#### Model

`App\Paleocoran\Codex\CodexPageDesignHeadingType`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `paleocoran_manuscript_codex_id` - reference to the parent reconstructed manuscript codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))
* `heading_type` - type of heading used in the given reconstructed codex

---

## paleocoran_codex_page_design_justification

#### Description

Types of justifications used in the reconstructed codices

#### Model

`App\Paleocoran\Codex\CodexPageDesignJustifcation`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `paleocoran_manuscript_codex_id` - reference to the parent reconstructed manuscript codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))
* `justification` - type of justification used in the given reconstructed codex

---

## paleocoran_codex_quire_composition

#### Description

Information about the quire composition in the reconstructed codices

#### Model

`App\Paleocoran\Codex\CodexQuireComposition`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `paleocoran_manuscript_codex_id` - reference to the parent reconstructed manuscript codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))
* `composition` - type of composition used in the given reconstructed codex

---

## paleocoran_codex_quire_types

#### Description

Quire types used in the reconstructed codices

#### Model

`App\Paleocoran\Codex\CodexQuireType`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `paleocoran_manuscript_codex_id` - reference to the parent reconstructed manuscript codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))
* `quire_type` - type of quire used in the given reconstructed codex

---

## paleocoran_codex_ruling_systems

#### Description

Ruling systems used in the reconstructed codices

#### Model

`App\Paleocoran\Codex\CodexRulingSystem`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `paleocoran_manuscript_codex_id` - reference to the parent reconstructed manuscript codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))
* `ruling_system` - type of ruling system used in the given reconstructed codex

---

## paleocoran_codex_skins

#### Description

Skins used in the reconstructed codices

#### Model

`App\Paleocoran\Codex\CodexSkin`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `paleocoran_manuscript_codex_id` - reference to the parent reconstructed manuscript codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))
* `skin` - type of skin used in the given reconstructed codex

---

## paleocoran_manuscript_codex

#### Description

Metadata container for the reconstructed codices. Represents the virtually reconstructed codex (not to be confused with the actual manuscripts!)

#### Model

`App\Paleocoran\Codex\Codex`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `name` - name of the reconstructed codex
* `storage` - comment about how the reconstructed codex is/has been stored
* `origin` - comment about the origin of the reconstructed codex
* `dimensions_outer_max_width` - width of the material
* `dimensions_outer_max_height` - height of the material
* `dimensions_inner_max_width` - width of the text on the material
* `dimensions_inner_max_height` - height of the text on the material
* `orientation` - orientation of the material (horizontal/vertical)
* `lines_per_page` - number of lines per page
* `notes` - general comment
* `colophon_scribe` - information about the scribe according to the colophon
* `colophon_patron` - information about the patron according to the colophon
* `colophon_date` - information about the date of publishing/writing according to the colophon
* `colophon_place` - geospatial information according to the colophon
* `waqf_donor` - information about associated donating institutions
* `waqf_beneficiary_institution` - information about associated institutions benefiting from the donations
* `waqf_date` - temporal information about the waqf
* `waqf_citation` - citation for the waqf
* `classification_notes` - general comment about the classification
* `paleographic_description` - general description about paleography
* `corrections` - general comment about corrections in the reconstructed codex
* `material` - general comment about the materials used in the reconstructed codex
* `grain` - information about the grain of the material of the reconstructed codex
* `thickness` - information about the thickness of the material of the reconstructed codex
* `pigmentation` - information about the pigmenation of the material of the reconstructed codex
* `hair_follicles` - information about hair follicles in the material of the reconstructed codex
* `animal_species` - information about the animal species used to create the material of the reconstructed codex
* `skin_treatment` - information about how the skin used to create the material of the reconstructed codex was treated
* `quires_preserved` - information about how many quires have been preserved over time 
* `quires_estimated` - information about how many quires there might have been originally
* `quire_correspondant_folding` - information about how the quires were folded to form the codex
* `membrane_disposition_gregory` - information about the membrane of the material according to Gregory
* `membrane_disposition_outer_side` - information about the outser side of the membrane
* `membrane_disposition_central_bifolium` - information about the central bifolium of the membrane
* `ruling_means_of_ruling` - information about how the ruling was a applied
* `ruling_pricking` - information about how the ruling was pricked
* `ruling_line_ruling_type` - information about the type of ruling
* `ink_category` - categorization of the ink used in the reconstructed codex
* `ink_corrections_and_additions` - information about ink that has been corrected or added later
* `ink_pingments_text` - information about ink pigments occurring in the text
* `ink_pigments_vowels` - information about ink pigments that indicate some form of vocalization in the written text
* `ink_pigments_ornaments` - information about the ornamental use of ink in the reconstructed codex
* `ink_other_components` - information about other components where ink has been used
* `ink_analysis` - information about the scientific analysis of the ink
* `page_design_margin` - information about the margin in the page design
* `page_design_writing_lines` - information about the lines that were used to create a sense of alignment in the text
* `page_design_interlinear_space` - information about the space left between the lines written
* `page_design_other_remarks` - other remarks regarding the page design
* `page_design_heading_title_type_of_script` - information about the script used in headings
* `page_design_heading_title_color` - information about the color used in headings
* `page_design_heading_title_formula_title_relation` - information about the formulas and patterns used in the headings
* `page_design_heading_title_formula_additional_information` - additional information about headings occurring in the reconstructed codex
* `illumination_quality_of_execution_rating` - rating on how well the illuminations in the given reconstructed codex have been applied
* `illumination_quality_of_execution_comment` - justification why the rating in `illumination_quality_of_execution_rating` was selected
* `comment_Variant_readings` - general comment about all variant readings in the given reconstructed codex
* `comment_variants_in_orthography` - general comment about all variants in orthography in the given reconstructed codex
* `comment_verse_separators` - general comment about all verse separators in the given reconstructed codex
* `bibliography` - aggregation of all literature used to describe the given reconstructed codex 

---

## paleocoran_manuscript_codex_manuscripts

#### Description

Mappings of which (parts of ) manuscripts (i.e. [manuskript](#manuskript)) have been assigned to be a part of a reconstructed codex ([paleocoran_manuscript_codex](#paleocoran_manuscript_codex))

#### Model

`App\Paleocoran\Codex\CodexManuscriptPivot`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `paleocoran_manuscript_codex_id` - ID of the referenced reconstructed codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))
* `manuskript_id` - ID of the referenced manuscript (`ID` in [manuskript](#manuskript))
* `manuskript_folio_start` - *(optional)* - starting folio where the assignment starts (if only a part of the given manuscript should be assigned to a codex); concurs with `Folio` in [manuskriptseiten](#manuskriptseiten)    
* `manuskript_seite_start` - *(optional)* - starting page where the assignment starts (if only a part of the given manuscript should be assigned to a codex); concurs with `Seite` in [manuskriptseiten](#manuskriptseiten)  
* `manuskript_folio_end` - *(optional)* - ending folio where the assignment starts (if only a part of the given manuscript should be assigned to a codex); concurs with `Folio` in [manuskriptseiten](#manuskriptseiten)
* `manuskript_seite_end` - *(optional)* - ending page where the assignment starts (if only a part of the given manuscript should be assigned to a codex); concurs with `Seite` in [manuskriptseiten](#manuskriptseiten)

---

## paleocoran_manuscript_codex_mappings

#### Description

List of text ranges the reconstructed codices range over, identified by starting and ending coordinate

#### Model

`App\Paleocoran\Codex\CodexMapping`

#### Fields

* `id` - incrementing ID
* `created_at` - creation timestamp
* `updated_at` - update timestamp
* `paleocoran_manuscript_codex_id` - ID of the referenced reconstructed codex (`id` in [paleocoran_manuscript_codex](#paleocoran_manuscript_codex))
* `codex_manuscript_mapping_id` - reference to the codex-manuscript-mapping the current text range list belongs to (`id` in [paleocoran_manuscript_codex_manuscripts](#paleocoran_manuscript_codex_manuscripts))
* `sure_start` - number of the starting sura according to Kairo
* `vers_start` - number of the starting verse in the given sura according to Kairo
* `word_start` - number of the starting word  in the given verse according to Kairo
* `sure_ende` - number of the ending sura according to Kairo
* `vers_ende` - number of the ending verse in the given sura according to Kairo
* `wort_ende` - number of the ending word  in the given verse according to Kairo
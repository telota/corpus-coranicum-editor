@extends('layouts.master')

@section('title')
    <h1>
        {{$manuskript->getName()}}
        <a href="{{ URL::action([App\Http\Controllers\ManuscriptNewController::class, 'edit'], $manuskript->id) }}"
           xmlns:v-bind="http://www.w3.org/1999/xhtml">
            <span class="glyphicon glyphicon-pencil glyphicon-hover" title="Manuskript bearbeiten"></span>
        </a>
    </h1>
@endsection

@section('content')
    @if ($manuskript->is_online)
        <div class="flex-container">

            <a href="{{ $manuskript->corpusCoranicumLink }}" class="btn btn-success flex-item" target="_blank">
                <span class="glyphicon glyphicon-globe"></span>
                Open on Corpus Coranicum
            </a>

        </div>
        <hr>
    @endif
    <h2>Summary</h2>
    <ul class="list-group">
        <li class="list-group-item">
            <x-manuscript-publish-button :id='$manuskript->id' :isOnline='$manuskript->is_online'
                                         :noImages='$manuskript->no_images' />
        </li>
        <li class="list-group-item">
            <span class="label label-default">Images allowed</span>
            {{ $manuskript->no_images ? "No" : "Yes" }}
            @if($manuskript->no_images)
                <x-manuscript-images-permission :manuscriptId='$manuskript->id' :disallow='false' />
            @else
                <x-manuscript-images-permission :manuscriptId='$manuskript->id' :disallow='true' />
            @endif
            <span style='padding-left:30px'/>
            <x-manuscript-images-publish-all :manuscriptId='$manuskript->id' />
            <span style='padding-left:30px'/>
            <x-manuscript-images-unpublish-all :manuscriptId='$manuskript->id' />
        </li>
        <li class="list-group-item">
            <span class="label label-default">Images Online Count</span>
            {{ sizeof($manuskript->images->filter(fn($i) => $i->private_use_only == false)) }} / {{ sizeof($manuskript->images) }}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Restricted Images Count</span>
            {{ sizeof($manuskript->images->filter( fn($i) => $i->private_use_only == true)) }} / {{ sizeof($manuskript->images) }}
        </li>
        <li class ="list-group-item">
            <span class="label label-default">Pages Online Count</span>
            {{ sizeof($manuskript->manuscriptPages->filter( fn($i) => $i->is_online == true)) }} / {{ sizeof($manuskript->manuscriptPages) }}
            <span style='padding-left:30px'/>
            <x-manuscript-pages-publish-all :manuscriptId='$manuskript->id' />
            <span style='padding-left:30px'/>
            <x-manuscript-pages-unpublish-all :manuscriptId='$manuskript->id' />
        </li>
    </ul>



    {{--    @include("includes.metadata", array("record" => $manuskript)) --}}
    <h2>Metadata</h2>


    <?php

    $readingSignsFunctions = implode(', ', array_column($manuskript->readingSignsFunctions->all(), 'reading_sign_function'));

    ?>

    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">ID</span>
            {!! $manuskript->id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Call Number</span>
            {!! $manuskript->call_number !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Place ID</span>
            {!! $manuskript->place_id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Place</span>
            {!! \App\Models\Manuscripts\Place::getReadableName($manuskript->place_id) !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Provenances</span>
            {!! $manuskript->provenances->pluck('provenance')->implode(";") !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Regional Writing Tradition Provenances</span>
            {!! $manuskript->rwtProvenances->pluck('provenance')->implode(";") !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Carbon Dating</span>
            {!! $manuskript->carbon_dating !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Date Start</span>
            <b>Gregorian:</b>
            {!! $manuskript->date_start !!}
            {{-- |  <b>Hijri:</b> --}}
            {{-- {!! \App\Models\Manuscripts\ManuscriptNew::gregorianToHijriDate($manuskript->date_start) !!} --}}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Date End</span>
            <b>Gregorian:</b>
            {!! $manuskript->date_end !!}
            {{-- |  <b>Hijri:</b> --}}
            {{-- {!! \App\Models\Manuscripts\ManuscriptNew::gregorianToHijriDate($manuskript->date_end) !!} --}}
        </li>

        <li class="list-group-item">
            <span class="label label-default">Writing Surface</span>
            {!! $manuskript->writing_surface !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Palimpsest</span>
            {!! $manuskript->palimpsest !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Sajda Signs</span>
            {!! $manuskript->sajda_signs !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Colophon</span>
            {!! $manuskript->colophon !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">DOI</span>
            {!! $manuskript->doi !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Credit Line Image</span>
            {!! $manuskript->credit_line_image !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Fundings</span>
            {{ $manuskript->funders->pluck('funder')->implode(';') }}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Reading Signs</span>
            {!! $manuskript->readingSigns->pluck('reading_sign')->implode(";") !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Function of the Reading Signs</span>
            {!! $readingSignsFunctions !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Verssegmentation</span>
            {!! $manuskript->verseSegmentations->pluck('name')->implode(";") !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Attributed To</span>
            {!! $manuskript->attributedTo->pluck('person')->implode(";") !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Script Styles</span>
            {{ $manuskript->scriptStyles->pluck('style')->implode(";") }}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Diacritic</span>
            {!! $manuskript->diacritics->pluck('diacritic')->implode(";") !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Quran Text</span>
            {!! $manuskript->extractTextstelle() !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created At</span>
            {!! $manuskript->created_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated At</span>
            {!! $manuskript->updated_at !!}
        </li>
    </ul>


    <h3>
        Formats
    </h3>


    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">Dimensions</span>
            {!! $manuskript->dimensions !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Format Text Field</span>
            {!! $manuskript->format_text_field !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Number of Lines</span>
            {!! $manuskript->number_of_lines !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Number of Folios</span>
            {!! $manuskript->number_of_folios !!}
        </li>
    </ul>

    @if ($manuskript->colophon == 'yes')
        <h3>
            Colophon
            <a href="{{ URL::action([App\Http\Controllers\ManuscriptColophonTranslationController::class, 'create'], $manuskript->id) }}"
               title="Neue Colophon Text Translation hinzufügen">
                <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
            </a>
        </h3>

        <ul class="list-group">
            <li class="list-group-item">
                <span class="label label-default">Colophon Date Start</span>
                <b>Gregorian:</b>
                {!! $manuskript->colophon_date_start !!}
                | <b>Hijri:</b>
                {!! \App\Models\Manuscripts\ManuscriptNew::gregorianToHijriDate($manuskript->colophon_date_start) !!}
            </li>
            <li class="list-group-item">
                <span class="label label-default">Colophon Date End</span>
                <b>Gregorian:</b>
                {!! $manuskript->colophon_date_end !!}
                | <b>Hijri:</b>
                {!! \App\Models\Manuscripts\ManuscriptNew::gregorianToHijriDate($manuskript->colophon_date_end) !!}
            </li>
            <li class="list-group-item">
                <span class="label label-default">Colophon Text</span>
                {!! $manuskript->colophon_text !!}
            </li>
            <h5>Translations:</h5>
            @foreach ($manuskript->colophonTranslations as $colophonTranslation)
                    <?php $language = $colophonTranslation->language->translation_language; ?>
                <li class="list-group-item">
                    <span class="label label-default">{{ ucfirst($language) }} Colophon</span>
                    {!! $colophonTranslation->colophon_text_translation !!}
                    <a href="{{ URL::action([App\Http\Controllers\ManuscriptColophonTranslationController::class, 'show'], $colophonTranslation->id) }}"
                       title="Translation anzeigen">
                        <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                    </a>
                    <a href="{{ URL::action([App\Http\Controllers\ManuscriptColophonTranslationController::class, 'edit'], $colophonTranslation->id) }}">
                        <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif


    @if ($manuskript->palimpsest == 'yes')
        <h3>
            Palimpsest
            <a href="{{ URL::action([App\Http\Controllers\ManuscriptPalimpsestTranslationController::class, 'create'], $manuskript->id) }}"
               title="Neue Palimpsest Text Translation hinzufügen">
                <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
            </a>
        </h3>

        <ul class="list-group">
            <li class="list-group-item">
                <span class="label label-default">Palimpsest Text</span>
                {!! $manuskript->palimpsest_text !!}
            </li>
            <h5>Translations:</h5>
            @foreach ($manuskript->palimpsestTranslations as $palimpsestTranslation)
                    <?php $language = $palimpsestTranslation->language->translation_language; ?>
                <li class="list-group-item">
                    <span class="label label-default">{{ ucfirst($language) }} Palimpsest</span>
                    {!! $palimpsestTranslation->palimpsest_text_translation !!}
                    <a href="{{ URL::action([App\Http\Controllers\ManuscriptPalimpsestTranslationController::class, 'show'], $palimpsestTranslation->id) }}"
                       title="Translation anzeigen">
                        <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                    </a>
                    <a
                            href="{{ URL::action([App\Http\Controllers\ManuscriptPalimpsestTranslationController::class, 'edit'], $palimpsestTranslation->id) }}">
                        <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif


    @if ($manuskript->sajda_signs == 'yes')
        <h3>
            Sajda Signs
            <a href="{{ URL::action([App\Http\Controllers\ManuscriptSajdaSignsTranslationController::class, 'create'], $manuskript->id) }}"
               title="Neue Sajda Signs Text Translation hinzufügen">
                <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
            </a>
        </h3>

        <ul class="list-group">
            <li class="list-group-item">
                <span class="label label-default">Sajda Signs Text</span>
                {!! $manuskript->sajda_signs_text !!}
            </li>
            <h5>Translations:</h5>
            @foreach ($manuskript->sajdaSignsTranslations as $sajdaSignsTranslation)
                    <?php $language = $sajdaSignsTranslation->language->translation_language; ?>
                <li class="list-group-item">
                    <span class="label label-default">{{ ucfirst($language) }} Sajda Signs</span>
                    {!! $sajdaSignsTranslation->sajda_signs_text_translation !!}
                    <a href="{{ URL::action([App\Http\Controllers\ManuscriptSajdaSignsTranslationController::class, 'show'], $sajdaSignsTranslation->id) }}"
                       title="Translation anzeigen">
                        <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                    </a>
                    <a
                            href="{{ URL::action([App\Http\Controllers\ManuscriptSajdaSignsTranslationController::class, 'edit'], $sajdaSignsTranslation->id) }}">
                        <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif



    <h3>
        Authors
    </h3>

    <table class="table">
        <tbody>
        @foreach(['metadata','transliteration','image','assistance'] as $role)
            <x-form.authors :entity='$manuskript' :$role module='manuscript'
                            :action='\App\Enums\FormAction::Show' />
        @endforeach
        </tbody>
    </table>

    <ul class='list-group'>
        <li class="list-group-item">

            <span class="label label-default">Created By</span>
            {!! $manuskript->created_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated By</span>
            {!! $manuskript->updated_by !!}
        </li>
    </ul>

    <h3>
        Texts
    </h3>

    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">Codicology</span>
            {!! $manuskript->codicology !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Paleography</span>
            {!! $manuskript->paleography !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Commentary Internal</span>
            {!! $manuskript->commentary_internal !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Ornaments</span>
            {!! $manuskript->ornaments !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Catalogue Entry</span>
            {!! $manuskript->catalogue_entry !!}
        </li>

    </ul>

    {{--    <h3> --}}
    {{--        <a data-toggle="collapse" href="#collapse1">Transliteration</a> --}}
    {{--    </h3> --}}
    {{--    <div id="collapse1" class="panel-collapse collapse list-group-item"> --}}
    {{--        <div class="panel-body"> --}}
    {{--            {!! $manuskript->transliteration !!} --}}
    {{--        </div> --}}
    {{--    </div> --}}



    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                        Transliteration</a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
                    {!! $manuskript->transliteration !!}
                </div>
            </div>
        </div>
    </div>

    {{--    SISTER LEAVES / ORIGINAL CODEX --}}
    @if ($manuskript->originalCodex()->first() && $manuskript->originalCodex()->first()->original_codex_name != 'keine')
            <?php
            if ($manuskript->originalCodex()->first() || $manuskript->originalCodex()->first()->original_codex_name != 'keine') {
                $originalCodex = $manuskript->originalCodex()->first();
                if ($originalCodex->supercategory) {
                    $originalCodexSuper = $originalCodex->supercategory->first()->original_codex_name;
                    $originalCodexTitle = $originalCodex->original_codex_name . ' : ' . $originalCodex->original_codex_name;
                } else {
                    $originalCodexTitle = $originalCodex->original_codex_name;
                }
            }

            ?>
        <div class="panel panel-default">

            <div class="panel-heading">
                <h4>Sister Leaves / Original Codex
                </h4>
                <div>
                    <h5> {!! $originalCodexTitle !!}
                    </h5>
                </div>
            </div>

            <div class="panel-body">

                <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Place</th>
                        <th>Call Number</th>
                        <th>Online</th>
                    </tr>
                    </thead>

                    @foreach ($originalCodex->manuscripts as $sisterManuscript)
                        <tr>
                            <td>{{ $sisterManuscript->id }}</td>

                            <td>{{ \App\Models\Manuscripts\Place::getReadableName($sisterManuscript->place_id) }}</td>
                            <td>
                                {{ $sisterManuscript->call_number }}
                            </td>
                            <td>
                                {{ $sisterManuscript->is_online ? "Ja" : "Nein" }}
                                <span class="pull-right">
                                    <a href="{{ URL::action([App\Http\Controllers\ManuscriptNewController::class, 'show'], $sisterManuscript->id) }}">
                                        <span class="glyphicon glyphicon-eye-open glyphicon-hover"
                                              title="Antiquity Market anzeigen"></span>
                                    </a>
                                    <a href="{{ URL::action([App\Http\Controllers\ManuscriptNewController::class, 'edit'], $sisterManuscript->id) }}">
                                        <span class="glyphicon glyphicon-pencil glyphicon-hover"
                                              title="Antiquity Market bearbeiten"></span>
                                    </a>
                                </span>
                            </td>

                        </tr>
                    @endforeach
                </table>

            </div>

        </div>
    @endif

    {{-- ANTIQUITY MARKET --}}

    @if (count($manuskript->antiquityMarkets) == 0)
        <div class="panel panel-default">

            <div class="panel-heading">
                <h4>Antiquity Market
                    {{--                    <a href="{{ URL::action([App\Http\Controllers\ManuscriptAntiquityMarketController::class, 'create'], $manuskript->id) }}"--}}
                    {{--                       title="Neuen Antiquity Market hinzufügen">--}}
                    {{--                        <span class="glyphicon glyphicon-plus glyphicon-hover"></span>--}}
                    {{--                    </a>--}}
                </h4>

            </div>
        </div>
    @endif

    @if (count($manuskript->antiquityMarkets) == 1)
            <?php
            $antiquityMarket = $manuskript->antiquityMarkets->first();
            $auctionHouse = $antiquityMarket->auctionHouse()->first();
            $auctionHouse = $auctionHouse !== null ? $auctionHouse->auction_house : '';
            $date = $antiquityMarket->auction_date;
            $antiquityPrice = $antiquityMarket->price;
            $antiquityCurrency = $antiquityMarket->currency;

            $currencies = array_flip($manuskript->getCurrencies());

            $currencyName = $currencies[$antiquityCurrency];

            if (($currencyName == 'Dollar') | ($currencyName == 'Euro') | ($currencyName == 'Pound sterling')) {
                $price = $antiquityCurrency . $antiquityPrice;
            } elseif ($currencyName == 'Deutsche Mark (DM)') {
                $price = $antiquityCurrency . ' ' . $antiquityPrice;
            } elseif ($currencyName == 'Reichsmark (RM)') {
                $price = $antiquityPrice . ' ' . $antiquityCurrency;
            } else {
                $price = $antiquityCurrency;
            }
            ?>

        <div class="panel panel-default">

            <div class="panel-heading">
                <h4>Antiquity Market
                    <a href="{{ URL::action([App\Http\Controllers\ManuscriptAntiquityMarketController::class, 'create'], $manuskript->id) }}"
                       title="Neuen Antiquity Market hinzufügen">
                        <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
                    </a>
                    <a href="{{ URL::action([App\Http\Controllers\ManuscriptAntiquityMarketController::class, 'edit'], $antiquityMarket->id) }}">
                        <span class="glyphicon glyphicon-pencil glyphicon-hover"
                              title="Antiquity Market bearbeiten"></span>
                    </a>
                </h4>

            </div>

            <div class="panel-body">

                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="label label-default">Auction House</span>
                        {!! $auctionHouse !!}
                    </li>
                    <li class="list-group-item">
                        <span class="label label-default">Date</span>
                        {!! $date !!}
                    </li>
                    <li class="list-group-item">
                        <span class="label label-default">Price</span>
                        {!! $price !!}
                    </li>
                </ul>

            </div>

        </div>
    @endif

    @if (count($manuskript->antiquityMarkets) > 1)
        <div class="panel panel-default">

            <div class="panel-heading">
                <h4>Antiquity Market
                    <a href="{{ URL::action([App\Http\Controllers\ManuscriptAntiquityMarketController::class, 'create'], $manuskript->id) }}"
                       title="Neuen Antiquity Market hinzufügen">
                        <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
                    </a>
                </h4>

            </div>

            <div class="panel-body">

                <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Auction House</th>
                        <th>Auction Date</th>
                        <th>Price</th>
                    </tr>
                    </thead>

                    @foreach ($manuskript->antiquityMarkets as $antiquityMarket)
                        <tr>
                            <td>{{ $antiquityMarket->id }}</td>

                            <td>{{ $antiquityMarket->auctionHouse ? $antiquityMarket->auctionHouse->auction_house : '' }}
                            </td>
                            <td>
                                {{ $antiquityMarket->auction_date }}
                            </td>
                            <td>
                                {{ $antiquityMarket->price . ' ' . $antiquityMarket->currency }}
                                <span class="pull-right">
                                    <a
                                            href="{{ URL::action([App\Http\Controllers\ManuscriptAntiquityMarketController::class, 'show'], $antiquityMarket->id) }}">
                                        <span class="glyphicon glyphicon-eye-open glyphicon-hover"
                                              title="Antiquity Market anzeigen"></span>
                                    </a>
                                    <a
                                            href="{{ URL::action([App\Http\Controllers\ManuscriptAntiquityMarketController::class, 'edit'], $antiquityMarket->id) }}">
                                        <span class="glyphicon glyphicon-pencil glyphicon-hover"
                                              title="Antiquity Market bearbeiten"></span>
                                    </a>
                                </span>
                            </td>

                        </tr>
                    @endforeach
                </table>

            </div>

        </div>
    @endif

    <hr>

    <h2>
        Manuskriptseiten
        <a href="{{ URL::action([App\Http\Controllers\ManuscriptPageController::class, 'create'], $manuskript->id) }}"
           title="Neue Manuskriptseite hinzufügen">
            <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
        </a>
    </h2>
    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
        <thead>
        <tr>
            <th>Folio</th>
            <th>Seite</th>
            <th>Textstelle</th>
            <th>Webtauglich</th>
        </tr>
        </thead>

        @foreach ($manuskript->manuscriptPages as $page)
            <tr>
                <td>{{ $page->folio }}</td>
                <td>
                    {{ $page->page_side }}
                </td>
                <td>
                    {{ $page->extractTextstelle() }}

                </td>

                <td>
                    {{ $page->is_online ? "ja" : "nein"}}
                    <span class="pull-right">
                        <a
                                href="{{ URL::action([App\Http\Controllers\ManuscriptPageController::class, 'show'], [
                                'manuscript_id' => $manuskript->id,
                                'page_id' => $page->id,
                            ]) }}">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"
                                  title="Manuskriptseite anzeigen"></span>
                        </a>
                        <a
                                href="{{ URL::action([App\Http\Controllers\ManuscriptPageController::class, 'edit'], [
                                'manuscript_id' => $manuskript->id,
                                'page_id' => $page->id,
                            ]) }}">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"
                                  title="Manuskriptseite bearbeiten"></span>
                        </a>

                        {{-- DELETE BUTTON --}}
                        <x-modal-button
                                :id='"delete-page-" . $page->id'
                                buttonClass='btn-danger'
                                buttonMessage='Delete'
                                buttonIcon='trash'
                                :title='"Are you sure you want to delete this page: {$page->folio}{$page->page_side}"'
                        >
                            <x-slot:message>
                                                <p>The corresponding items from this manuscript page
                                                                            will also be deleted:</p>
                                                                        <ul>
                                                                            <li>Images (including the image files)</li>
                                                                            <li>Qur'an Mappings</li>
                                                                        </ul>

                            </x-slot:message>
                            <x-slot:submit>
                                <form style='display: inline'
                                      action={{route('ms_page.delete', ['manuscript_id'=>$manuskript->id, 'page_id'=>$page->id])}}
                                      method='POST'>
                                    {{ csrf_field() }}
                                    @method('DELETE')
                                    <button class="btn btn-danger" type='submit'>
                                        <span class='glyphicon glyphicon-trash'></span>
                                        Delete
                                    </button>
                                </form>
                            </x-slot:submit>
                        </x-modal-button>
                    </span>
                </td>
            </tr>
        @endforeach
    </table>
@endsection

<?php

use App\Http\Controllers\IntertextCategoryInformationTranslationController;
use App\Http\Controllers\IntertextController;
use App\Http\Controllers\IntertextEntryTranslationController;
use App\Http\Controllers\IntertextInformationAuthorController;
use App\Http\Controllers\IntertextOriginalLanguageController;
use App\Http\Controllers\IntertextOriginalTranslationController;
use App\Http\Controllers\IntertextScriptController;
use App\Http\Controllers\IntertextSourceAuthorController;
use App\Http\Controllers\IntertextSourceAuthorInformationTranslationController;
use App\Http\Controllers\IntertextSourceController;
use App\Http\Controllers\IntertextSourceInformationTranslationController;
use App\Http\Controllers\IntertextTranslationLanguageController;
use App\Http\Controllers\UmwelttexteController;
use Illuminate\Support\Facades\Route;

// Umwelttexte routes...
Route::get("umwelttexte", [UmwelttexteController::class, 'index']);
Route::get("umwelttexte/index", [UmwelttexteController::class, 'index']);
Route::get(
    "umwelttexte/index/sure/{sure}",
    [UmwelttexteController::class, 'indexSure']
)->name("umwelttexte.index.sure");
Route::get(
    "umwelttexte/index/sure/{sure}/vers/{vers}",
    [UmwelttexteController::class, 'indexVers']
)->name("umwelttexte.index.vers");
Route::get(
    "umwelttexte/index/language/{lang}",
    [UmwelttexteController::class, 'indexLanguage']
)->name('umwelttexte.index.language');
Route::get(
    "/umwelttexte/index/kategorie/{kategorie}",
    [UmwelttexteController::class, 'indexKategorie']
)->name("umwelttexte.index.kategorie");

Route::get("umwelttexte/show/{id}", [UmwelttexteController::class, 'show']);

Route::group(["prefix" => "umwelttexte"], function () {
    Route::get("/edit/{id}", [UmwelttexteController::class, 'edit']);
    Route::get("/create", [UmwelttexteController::class, 'create']);
    Route::post("/update/{id}", [UmwelttexteController::class, 'update']);
    Route::post("/store", [UmwelttexteController::class, 'store']);
});

// Intertexts routes...
Route::get("intertexts", [IntertextController::class, 'index']);
Route::get("intertexts/index", [IntertextController::class, 'index']);
Route::get(
    "intertexts/index/sure/{sure}",
    ["as" => "intertexts.index.sure", "uses" => [IntertextController::class, 'indexSure']]
);
Route::get(
    "intertexts/index/sure/{sure}/vers/{vers}",
    ["as" => "intertexts.index.vers", "uses" => [IntertextController::class, 'indexVers']]
);
Route::get(
    "intertexts/index/language/{lang}",
    ["as" => "intertexts.index.language", "uses" => [IntertextController::class, 'indexLanguage']]
);
Route::get(
    "/intertexts/index/category/{category}",
    ["as" => "intertexts.index.category", "uses" => [IntertextController::class, 'indexCategory']]
);
Route::get("intertexts/show/{id}", [IntertextController::class, 'show']);

Route::group(["prefix" => "intertexts"], function () {
    Route::get("/edit/{id}", [IntertextController::class, 'edit']);
    Route::get("/create", [IntertextController::class, 'create']);
    Route::post("/update/{id}", [IntertextController::class, 'update']);
    Route::post("/store", [IntertextController::class, 'store']);
});

// Intertext Original Language routes...
Route::get('intertext-original-language', [IntertextOriginalLanguageController::class, 'index']);
Route::get('intertext-original-language/index', [IntertextOriginalLanguageController::class, 'index']);
Route::get('intertext-original-language/show/{id}', [IntertextOriginalLanguageController::class, 'show']);

Route::group(["prefix" => "intertext-original-language"], function () {
    Route::get('/edit/{id}', [IntertextOriginalLanguageController::class, 'edit']);
    Route::get('/create', [IntertextOriginalLanguageController::class, 'create']);
    Route::post("/update/{id}", [IntertextOriginalLanguageController::class, 'update']);
    Route::post("/store", [IntertextOriginalLanguageController::class, 'store']);
});

// Intertext Translation Language routes...
Route::get('intertext-translation-language', [IntertextTranslationLanguageController::class, 'index']);
Route::get('intertext-translation-language/index', [IntertextTranslationLanguageController::class, 'index']);
Route::get('intertext-translation-language/show/{id}', [IntertextTranslationLanguageController::class, 'show']);

Route::group(["prefix" => "intertext-translation-language"], function () {
    Route::get('/edit/{id}', [IntertextTranslationLanguageController::class, 'edit']);
    Route::get('/create', [IntertextTranslationLanguageController::class, 'create']);
    Route::post("/update/{id}", [IntertextTranslationLanguageController::class, 'update']);
    Route::post("/store", [IntertextTranslationLanguageController::class, 'store']);
});

//  Intertext Entry Translation routes...
Route::get('intertext-entry-translation/show/{id}', [IntertextEntryTranslationController::class, 'show']);

Route::group(["prefix" => "intertext-entry-translation"], function () {
    Route::get('/edit/{id}', [IntertextEntryTranslationController::class, 'edit']);
    Route::get('/create/{intertextid}', [IntertextEntryTranslationController::class, 'create']);
    Route::post('/update/{id}', [IntertextEntryTranslationController::class, 'update']);
    Route::post('/store', [IntertextEntryTranslationController::class, 'store']);
});

//  Intertext Original Translation routes...
Route::get('intertext-original-translation/show/{id}', [IntertextOriginalTranslationController::class, 'show']);

Route::group(["prefix" => "intertext-original-translation"], function () {
    Route::get('/edit/{id}', [IntertextOriginalTranslationController::class, 'edit']);
    Route::get('/create/{intertextid}', [IntertextOriginalTranslationController::class, 'create']);
    Route::post('/update/{id}', [IntertextOriginalTranslationController::class, 'update']);
    Route::post('/store', [IntertextOriginalTranslationController::class, 'store']);
});


//  Intertext Source Information Translation routes...
Route::get('intertext-source-information-translation/show/{id}', [IntertextSourceInformationTranslationController::class, 'show']);

Route::group(["prefix" => "intertext-source-information-translation"], function () {
    Route::get('/edit/{id}', [IntertextSourceInformationTranslationController::class, 'edit']);
    Route::get('/create/{sourceId}', [IntertextSourceInformationTranslationController::class, 'create']);
    Route::post('/update/{id}', [IntertextSourceInformationTranslationController::class, 'update']);
    Route::post('/store', [IntertextSourceInformationTranslationController::class, 'store']);
});

//  Intertext Category.php Information Translation routes...
Route::get('intertext-source-author-information-translation/show/{id}', [IntertextSourceAuthorInformationTranslationController::class, 'show']);

Route::group(["prefix" => "intertext-source-author-information-translation"], function () {
    Route::get('/edit/{id}', [IntertextSourceAuthorInformationTranslationController::class, 'edit']);
    Route::get('/create/{sourceAuthorId}', [IntertextSourceAuthorInformationTranslationController::class, 'create']);
    Route::post('/update/{id}', [IntertextSourceAuthorInformationTranslationController::class, 'update']);
    Route::post('/store', [IntertextSourceAuthorInformationTranslationController::class, 'store']);
});

//  Intertext Category.php Information Translation routes...
Route::get('intertext-category-information-translation/show/{id}', [IntertextCategoryInformationTranslationController::class, 'show']);

Route::group(["prefix" => "intertext-category-information-translation"], function () {
    Route::get('/edit/{id}', [IntertextCategoryInformationTranslationController::class, 'edit']);
    Route::get('/create/{categoryId}', [IntertextCategoryInformationTranslationController::class, 'create']);
    Route::post('/update/{id}', [IntertextCategoryInformationTranslationController::class, 'update']);
    Route::post('/store', [IntertextCategoryInformationTranslationController::class, 'store']);
});


// Intertext Script Language routes...
Route::get('intertext-script', [IntertextScriptController::class, 'index']);
Route::get('intertext-script/index', [IntertextScriptController::class, 'index']);
Route::get('intertext-script/show/{id}', [IntertextScriptController::class, 'show']);

Route::group(["prefix" => "intertext-script"], function () {
    Route::get('/edit/{id}', [IntertextScriptController::class, 'edit']);
    Route::get('/create', [IntertextScriptController::class, 'create']);
    Route::post("/update/{id}", [IntertextScriptController::class, 'update']);
    Route::post("/store", [IntertextScriptController::class, 'store']);
});


// Intertext Source CCAuthor routes...
Route::get('intertext-source-author', [IntertextSourceAuthorController::class, 'index']);
Route::get('intertext-source-author/index', [IntertextSourceAuthorController::class, 'index']);
Route::get('intertext-source-author/show/{id}', [IntertextSourceAuthorController::class, 'show']);

Route::group(["prefix" => "intertext-source-author"], function () {
    Route::get('/edit/{id}', [IntertextSourceAuthorController::class, 'edit']);
    Route::get('/create', [IntertextSourceAuthorController::class, 'create']);
    Route::post("/update/{id}", [IntertextSourceAuthorController::class, 'update']);
    Route::post("/store", [IntertextSourceAuthorController::class, 'store']);
});


// Intertext Book routes...
Route::get('intertext-source', [IntertextSourceController::class, 'index']);
Route::get('intertext-source/index', [IntertextSourceController::class, 'index']);
Route::get('intertext-source/show/{id}', [IntertextSourceController::class, 'show']);

Route::group(["prefix" => "intertext-source"], function () {
    Route::get('/edit/{id}', [IntertextSourceController::class, 'edit']);
    Route::get('/create', [IntertextSourceController::class, 'create']);
    Route::post("/update/{id}", [IntertextSourceController::class, 'update']);
    Route::post("/store", [IntertextSourceController::class, 'store']);
});


// Intertext Information CCAuthor routes...
Route::get('intertext-information-author', [IntertextInformationAuthorController::class, 'index']);
Route::get('intertext-information-author/index', [IntertextInformationAuthorController::class, 'index']);
Route::get('intertext-information-author/show/{id}', [IntertextInformationAuthorController::class, 'show']);

Route::group(["prefix" => "intertext-information-author"], function () {
    Route::get('/edit/{id}', [IntertextInformationAuthorController::class, 'edit']);
    Route::get('/create', [IntertextInformationAuthorController::class, 'create']);
    Route::post("/update/{id}", [IntertextInformationAuthorController::class, 'update']);
    Route::post("/store", [IntertextInformationAuthorController::class, 'store']);
});


// Intertext Book Information routes...
Route::get('intertext-source-information', [IntertextBookInformationController::class, 'index']);
Route::get('intertext-source-information/index', [IntertextBookInformationController::class, 'index']);
Route::get('intertext-source-information/show/{id}', [IntertextBookInformationController::class, 'show']);

Route::group(["prefix" => "intertext-source-information"], function () {
    Route::get('/edit/{id}', [IntertextBookInformationController::class, 'edit']);
    Route::get('/create', [IntertextBookInformationController::class, 'create']);
    Route::post("/update/{id}", [IntertextBookInformationController::class, 'update']);
    Route::post("/store", [IntertextBookInformationController::class, 'store']);
});

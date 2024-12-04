<?php

use App\Http\Controllers\ManuscriptColophonTranslationController;
use App\Http\Controllers\ManuscriptNewController;
use App\Http\Controllers\ManuscriptPageController;
use App\Http\Controllers\ManuscriptPageImageController;
use App\Http\Controllers\ManuscriptPalimpsestTranslationController;
use App\Http\Controllers\ManuscriptSajdaSignsTranslationController;
use App\Http\Controllers\ManuscriptTransliterationAuthorController;
use App\Http\Controllers\ManuskriptController;
use App\Http\Controllers\ManuskriptseitenController;
use App\Http\Controllers\TransliterationsEditorController;
use Illuminate\Support\Facades\Route;

// Manuskript routes...
Route::get('manuskript', [ManuskriptController::class, 'index']);
Route::get('manuskript/index', [ManuskriptController::class, 'index']);
Route::get('manuskript/show/{id}', [ManuskriptController::class, 'show']);

// ManuscriptNew routes...

Route::prefix("manuscript-new")->name("manuscript.")->group(function () {
    Route::get('', [ManuscriptNewController::class, 'index'])->name('index');
    Route::get('/index', [ManuscriptNewController::class, 'index'])->name('index');
    Route::get('/show/{id}', [ManuscriptNewController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [ManuscriptNewController::class, 'edit'])->name('edit');
    Route::get('/create', [ManuscriptNewController::class, 'create'])->name('create');
    Route::post('/update/{id}', [ManuscriptNewController::class, 'update'])->name('update');
    Route::post('/store', [ManuscriptNewController::class, 'store'])->name('store');
});

Route::put('/ajax/manuscript/publish', [ManuscriptNewController::class, 'publish'])->name('manuscript_publish');
Route::put('/ajax/manuscript/{id}/publish-all-images', [ManuscriptNewController::class, 'publishImages'])
    ->name('manuscript_images_publish');
Route::put('/ajax/manuscript/{id}/unpublish-all-images', [ManuscriptNewController::class, 'unpublishImages'])
        ->name('manuscript_images_unpublish');
Route::put('/ajax/manuscript/{id}/restrict-images', [ManuscriptNewController::class, 'restrictImages'])
    ->name('manuscript_images_restrict');
Route::put('/ajax/manuscript/{id}/allow-images', [ManuscriptNewController::class, 'allowImages'])
    ->name('manuscript_images_allow');
Route::put('/ajax/manuscript/{id}/publish-all-pages', [ManuscriptNewController::class, 'publishPages'])
    ->name('manuscript_pages_publish');
Route::put('/ajax/manuscript/{id}/unpublish-all-pages', [ManuscriptNewController::class, 'unpublishPages'])
    ->name('manuscript_pages_unpublish');


// ManuscriptPage routes...
Route::group(["prefix" => '/manuscript/{manuscript_id}/page'], function () {
    Route::get('/{page_id}/show', [ManuscriptPageController::class, 'show'])->name('ms_page.show');
    Route::get('/create', [ManuscriptPageController::class, 'create']);
    Route::post('', [ManuscriptPageController::class, 'createOrEditHandler'])->name('ms_page_create');
    Route::get('/{page_id}/edit', [ManuscriptPageController::class, 'edit']);
    Route::put('/{page_id}', [ManuscriptPageController::class, 'createOrEditHandler']);
    Route::delete('/{page_id}', [ManuscriptPageController::class, 'destroy'])->name('ms_page.delete');
    Route::get('/edit-transliteration/{id}', [TransliterationsEditorController::class, 'edit']);
});

Route::group(["prefix" => '/ajax/manuscript/{manuscript_id}/page/{page_id}/image',],
    function () {
//        Route::get('/create', [ManuscriptPageImageController::class, 'create']);
//        Route::post('', [ManuscriptPageImageController::class, 'createOrEditHandler']);
//        Route::get('/{image_id}/edit', [ManuscriptPageImageController::class, 'edit']);
//        Route::put('{image_id?}', [ManuscriptPageImageController::class, 'createOrEditHandler']);
//        Route::delete('{image_id}', [ManuscriptPageImageController::class, 'destroy']);
    }
);

Route::group(["prefix" => 'manuscript/{manuscript_id}/page/{page_id}/image'], function () {
    Route::get('/create', [ManuscriptPageImageController::class, 'create'])->name('ms_image.create');
    Route::post('', [ManuscriptPageImageController::class, 'store']);
    Route::get('/{image_id}/edit', [ManuscriptPageImageController::class, 'edit'])->name('ms_image.edit');
    Route::put('{image_id?}', [ManuscriptPageImageController::class, 'store']);
    Route::delete('{image_id}', [ManuscriptPageImageController::class, 'destroy'])->name('ms_image.delete');

});

//  Manuscript Colophon Translation routes...
Route::get('manuscript-colophon-translation/show/{id}', [ManuscriptColophonTranslationController::class, 'show']);

Route::group(["prefix" => "manuscript-colophon-translation"], function () {
    Route::get('/edit/{id}', [ManuscriptColophonTranslationController::class, 'edit']);
    Route::get('/create/{manuscriptId}', [ManuscriptColophonTranslationController::class, 'create']);
    Route::post('/update/{id}', [ManuscriptColophonTranslationController::class, 'update']);
    Route::post('/store', [ManuscriptColophonTranslationController::class, 'store']);
});


//  Manuscript Palimpsest Translation routes...
Route::get('manuscript-palimpsest-translation/show/{id}', [ManuscriptPalimpsestTranslationController::class, 'show']);

Route::group(["prefix" => "manuscript-palimpsest-translation"], function () {
    Route::get('/edit/{id}', [ManuscriptPalimpsestTranslationController::class, 'edit']);
    Route::get('/create/{manuscriptId}', [ManuscriptPalimpsestTranslationController::class, 'create']);
    Route::post('/update/{id}', [ManuscriptPalimpsestTranslationController::class, 'update']);
    Route::post('/store', [ManuscriptPalimpsestTranslationController::class, 'store']);
});


//  Manuscript Sajda Signs Translation routes...
Route::get('manuscript-sajda-signs-translation/show/{id}', [ManuscriptSajdaSignsTranslationController::class, 'show']);

Route::group(["prefix" => "manuscript-sajda-signs-translation"], function () {
    Route::get('/edit/{id}', [ManuscriptSajdaSignsTranslationController::class, 'edit']);
    Route::get('/create/{manuscriptId}', [ManuscriptSajdaSignsTranslationController::class, 'create']);
    Route::post('/update/{id}', [ManuscriptSajdaSignsTranslationController::class, 'update']);
    Route::post('/store', [ManuscriptSajdaSignsTranslationController::class, 'store']);
});


// Manuskriptseiten routes...
Route::get('manuskriptseiten/show/{id}', [ManuskriptseitenController::class, 'show']);

// Assistances routes...
Route::get('assistance', [AssistanceController::class, 'index']);
Route::get('assistance/index', [AssistanceController::class, 'index']);
Route::get('assistance/show/{id}', [AssistanceController::class, 'show']);

Route::group(["prefix" => "assistance"], function () {
    Route::get('/edit/{id}', [AssistanceController::class, 'edit']);
    Route::get('/create', [AssistanceController::class, 'create']);
    Route::post("/update/{id}", [AssistanceController::class, 'update']);
    Route::post("/store", [AssistanceController::class, 'store']);
});

// Image Editor routes...
Route::get('image-editor', [ImageEditorController::class, 'index']);
Route::get('image-editor/index', [ImageEditorController::class, 'index']);
Route::get('image-editor/show/{id}', [ImageEditorController::class, 'show']);

Route::group(["prefix" => "image-editor"], function () {
    Route::get('/edit/{id}', [ImageEditorController::class, 'edit']);
    Route::get('/create', [ImageEditorController::class, 'create']);
    Route::post("/update/{id}", [ImageEditorController::class, 'update']);
    Route::post("/store", [ImageEditorController::class, 'store']);
});

// Transliteration CCAuthor routes...
Route::get('transliteration-author', [ManuscriptTransliterationAuthorController::class, 'index']);
Route::get('transliteration-author/index', [ManuscriptTransliterationAuthorController::class, 'index']);
Route::get('transliteration-author/show/{id}', [ManuscriptTransliterationAuthorController::class, 'show']);

Route::group(["prefix" => "transliteration-author"], function () {
    Route::get('/edit/{id}', [ManuscriptTransliterationAuthorController::class, 'edit']);
    Route::get('/create', [ManuscriptTransliterationAuthorController::class, 'create']);
    Route::post("/update/{id}", [ManuscriptTransliterationAuthorController::class, 'update']);
    Route::post("/store", [ManuscriptTransliterationAuthorController::class, 'store']);
});

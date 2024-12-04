<?php

use App\Http\Controllers\LeseartenController;
use App\Http\Controllers\LeserController;
use App\Http\Controllers\QuellenController;
use Illuminate\Support\Facades\Route;

// Lesarten: Leser routes...
Route::get("leser", [LeserController::class, 'index']);
Route::get("leser/index", [LeserController::class, 'index']);
Route::get("leser/show/{id}", [LeserController::class, 'show']);

Route::group(["prefix" => "leser"], function () {
    Route::get("/edit/{id}", [LeserController::class, 'edit']);
    Route::get("/create", [LeserController::class, 'create']);
    Route::get("/destroy/{id}", [LeserController::class, 'destroy']);
    Route::post("/update/{id}", [LeserController::class, 'update']);
    Route::post("/store", [LeserController::class, 'store']);
});

// Lesearten: Lesearten routes...
Route::get("lesearten", [LeseartenController::class, 'index']);
Route::get("lesearten/index", [LeseartenController::class, 'index']);
Route::get("lesearten/index/{page}", [LeseartenController::class, 'index']);
Route::get("lesearten/koranstellen", [LeseartenController::class, 'koranstellenindex']);
Route::get("lesearten/koranstellen/{sure}", [LeseartenController::class, 'koranstellenIndex']);
Route::get("lesearten/koranstellen/sure/{sure}/vers/{vers}", [LeseartenController::class, 'koranstellenShow']);
Route::get("lesearten/show/{id}", [LeseartenController::class, 'show'])->name('leseart.show');
Route::get(
    "lesearten/kommentar/show/sure/{sure}/vers/{vers}",
    ["as" => "showLeseartKommentar", "uses" => [LeseartenController::class, 'kommentarShow']]
);
Route::get("lesearten/wort/{word}", [LeseartenController::class, 'wordIndex']);


Route::prefix("lesearten")->name('lesearten.')->group(function () {
    Route::get("/create", [LeseartenController::class, 'create'])->name('create');
    Route::get("/edit/{id}", [LeseartenController::class, 'edit'])->name('edit');
    Route::get("/create/quelle/{quelle}", [LeseartenController::class, 'createFromSource'])->name('quellen.create');
    Route::get("/create/leser/{leser}", [LeseartenController::class, 'create'])->name('leser.create');
    Route::get("/create/quelle/leser/{leser?}", [LeseartenController::class, 'create']
    )->name('quellen.leser.create');
    Route::get("/create/sure/{sure}/vers/{vers}", [LeseartenController::class, 'createKoranstelle']
    )->name('koranstellen.create');
    Route::get(
        "/create/sure/{sure}/vers/{vers}/quelle/{quelle}/leser/{leser}",
        ["as" => "createLeseartKoranstelleQuelleLeser", "uses" => [LeseartenController::class, 'createKoranstelle']]
    );
    Route::post("/store", [LeseartenController::class, 'store'])->name('store');
    Route::put("/store/{id?}", [LeseartenController::class, 'store'])->name('update');
    Route::get(
        "/kommentar/edit/sure/{sure}/vers/{vers}",
        ["as" => "editLeseartKommentar", "uses" => [LeseartenController::class, 'kommentarEdit']]
    );
    Route::post(
        "/kommentar/update/",
        ["as" => "updateLeseartKommentar", "uses" => [LeseartenController::class, 'kommentarUpdate']]
    );
    Route::get("/destroy/{id}", [LeseartenController::class, 'destroy']);
});

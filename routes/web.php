<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\BelegstellenKategorieController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CCRoleController;
use App\Http\Controllers\CollegiumCoranicumController;
use App\Http\Controllers\DruckausgabeController;
use App\Http\Controllers\GenericController;
use App\Http\Controllers\HilfeController;
use App\Http\Controllers\IntertextCategoryController;
use App\Http\Controllers\KoranController;
use App\Http\Controllers\ManuscriptOriginalCodexController;
use App\Http\Controllers\MappingController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\VeranstaltungController;
use App\Http\Controllers\ZoteroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/phpinfo", fn()=>phpinfo());
// Home and login routes
Route::get("home", [HomeController::class, 'index'])->name('home');
Route::get('/', [AuthenticatedSessionController::class, 'create']);


include('intertext.php');
include('lesarten.php');
include('manuscript.php');
include('auth.php');



// Intertext CCAuthor routes...
Route::get('intertext-author', [IntertextAuthorController::class, 'index']);
Route::get('intertext-author/index', [IntertextAuthorController::class, 'index']);
Route::get('intertext-author/show/{id}', [IntertextAuthorController::class, 'show']);

Route::group(["prefix" => "intertext-author"], function () {
    Route::get('/edit/{id}', [IntertextAuthorController::class, 'edit']);
    Route::get('/create', [IntertextAuthorController::class, 'create']);
    Route::post("/update/{id}", [IntertextAuthorController::class, 'update']);
    Route::post("/store", [IntertextAuthorController::class, 'store']);
});


// Blog routes...
Route::get("blog/index", [BlogController::class, 'index']);
Route::get("blog", [BlogController::class, 'index']);
Route::get("blog/show/{id}", [BlogController::class, 'show']);

Route::group(["prefix" => "blog"], function () {
    Route::get("/edit/{id}", [BlogController::class, 'edit']);
    Route::get("/create", [BlogController::class, 'create']);
    Route::post("/update/{id}", [BlogController::class, 'update']);
    Route::post("/store", [BlogController::class, 'store']);
});

// Druckausgaben Routes
Route::get("druckausgabe/", [DruckausgabeController::class, 'index']);
Route::get(
    "druckausgabe/index",
    ["as" => "druckausgabe.index.all.de", "uses" => [DruckausgabeController::class, 'index']]
); // !sprache & !sure
Route::get(
    "druckausgabe/index/sure/{sure}",
    ["as" => "druckausgabe.index.sure.de", "uses" => [DruckausgabeController::class, 'index']]
); // !sprache & sure
Route::get(
    "druckausgabe/index/sprache/{sprache}",
    ["as" => "druckausgabe.index.all.sprache", "uses" => [DruckausgabeController::class, 'indexSprache']]
); // sprache & !sure
Route::get(
    "druckausgabe/index/{sure}/{sprache}",
    ["as" => "druckausgabe.index.sure.sprache", "uses" => [DruckausgabeController::class, 'index']]
); // sprache & sure



//Route::get("druckausgabe/show/{id}", ["as" => "druckausgabe.show.id", "uses" => [DruckausgabeController::class, 'show']]);
Route::get("druckausgabe/show/{sure}/{vers}", [DruckausgabeController::class, 'showByVerse']);

//Route::get("druckausgabe/edit/{id}", ["as" => "druckausgabe.edit", "uses" => [DruckausgabeController::class, 'edit']]);
Route::get("druckausgabe/edit/{sure}/{vers}", ["as" => "druckausgabe.edit.by.verse", "uses" => [DruckausgabeController::class, 'editByVerse']]);

//Route::post("druckausgabe/update/{id}", [DruckausgabeController::class, 'update']);
Route::post("druckausgabe/update/{sure}/{vers}", [DruckausgabeController::class, 'updateByVerse']);


// Translation routes
Route::get("translations/", [TranslationController::class, 'index']);
Route::get("translations/index", [TranslationController::class, 'index']);
Route::get("translations/show/{key}", [TranslationController::class, 'show'])->name('show_translation');

Route::group(["prefix" => "translations"], function () {
    //Route::resource("/", "TranslationController");
    Route::get("/edit/{key}", [TranslationController::class, 'edit']);
    Route::post("/update/{key}", [TranslationController::class, 'update']);
    Route::get("/export/{lang}", [TranslationController::class, 'export']);
    Route::get("/create", [TranslationController::class, 'create']);
    Route::post("/store", [TranslationController::class, 'store']);
});

// Zotero route
Route::get("zotero", [ZoteroController::class, 'index']);
Route::post("ajax/zotero/sync", [ZoteroController::class, 'sync']);

// Annotation routes
Route::get("annotate", [HomeController::class, 'annotate']);


// Koran routes
Route::group(["prefix" => "koran"], function () {
    Route::get("/", [KoranController::class, 'indexBySura'], ["sure" => 1]);
    Route::get("/index", [KoranController::class, 'indexBySura'], ["sure" => 1]);
    Route::get("/index/{sura}", [KoranController::class, 'indexBySura']);
    Route::get("/edit/{sure}/{vers}/{wort}", [KoranController::class, 'edit']);
    Route::post("/edit/{sure}/{vers}/{wort}", [KoranController::class, 'update']);
});

// Ajax routes...
Route::post('ajax/versselect', [AjaxController::class, 'createVersSelect']);
Route::post('ajax/addtextstelle', [AjaxController::class, 'addTextstelleInput']);
Route::post('ajax/addleser', [AjaxController::class, 'addLeserInput']);
Route::get('ajax/reading-variants/sura/{sura}/verse/{verse}', [AjaxController::class, 'changeVariantenInput']);
Route::post('ajax/parettransliteration', [AjaxController::class, 'getParetTransliteration']);
Route::post('ajax/addimage', [AjaxController::class, 'addImageInput']);
Route::post('ajax/addalias', [AjaxController::class, 'addAliasInput']);
// Route::post('ajax/getwordlist', [AjaxController::class, 'getWordsWithArabicAndTranscription']);
Route::post('ajax/addmanuscriptvariant', [AjaxController::class, 'addManuscriptVariant']);
Route::post('ajax/addvariantorthography', [AjaxController::class, 'addManuscriptOrthographyVariant']);
Route::post('ajax/addmanuscriptfeature', [AjaxController::class, 'addManuscriptFeature']);
Route::get("ajax/getallkoranstellen", [AjaxController::class, 'getAllKoranstellen']);
Route::get("ajax/get-manuscripts", [AjaxController::class, 'getManuscriptList']);
Route::post("ajax/get-manuscript-info", [AjaxController::class, 'getManuscriptInfo']);
Route::get("ajax/get-codex-manuscripts", [AjaxController::class, 'getCodexManuscripts']);
Route::get("ajax/get-codex-manuscript-pages", [AjaxController::class, 'getCodexManuscriptPages']);
Route::post("ajax/get-codex-classification", [AjaxController::class, 'getCodexClassification']);
Route::get("ajax/get-codex-illuminations", [AjaxController::class, 'getCodexIlluminations']);
Route::post("ajax/update-codex-illumination", [AjaxController::class, 'updateCodexIllumination']);
Route::post("ajax/remove-codex-illumination", [AjaxController::class, 'removeCodexIllumination']);
Route::get("ajax/get-verses", [AjaxController::class, 'getVerse']);
Route::get("ajax/get-words", [AjaxController::class, 'getWords']);
Route::get("ajax/quran/maxWords", [KoranController::class, 'getMaxWords']);
Route::get("ajax/quran/sura/{sura}/verse/{verse}", [KoranController::class, 'getVerse']);
Route::get("ajax/manuscript-page/new-mapping", [MappingController::class, 'newMapping']);
Route::get("ajax/intertext/new-mapping", function(){
    return (new App\Http\Controllers\MappingController)->newMapping(false);
});


// Manage Users routes...
Route::get("manage/users", [AdminController::class, 'index']);
Route::get("manage/users/index", [AdminController::class, 'index']);
Route::get("manage/users/show/{id}", [AdminController::class, 'show']);
Route::get("manage/users/edit/{id}", [AdminController::class, 'edit']);
Route::get("manage/users/create", [AdminController::class, 'create']);

Route::post("manage/users/store", [AdminController::class, 'store']);
Route::post("manage/users/update/{id}", [AdminController::class, 'update']);
Route::post("manage/users/reset/{id}", [AdminController::class, 'setPasswordReset']);

//Manage Belegstellen Routes
Route::get("belegstellenkategorie", [BelegstellenKategorieController::class, 'index']);
Route::get("belegstellenkategorie/edit/{id}", [BelegstellenKategorieController::class, 'edit']);
Route::post("belegstellenkategorie/update/{id}", [BelegstellenKategorieController::class, 'update']);
Route::get("belegstellenkategorie/create", [BelegstellenKategorieController::class, 'create']);
Route::post("belegstellenkategorie/store", [BelegstellenKategorieController::class, 'store']);


//Manage Intertext Category.php Routes
Route::get("intertext-category", [IntertextCategoryController::class, 'index']);
Route::get("intertext-category/show/{id}", [IntertextCategoryController::class, 'show']);
Route::get("intertext-category/edit/{id}", [IntertextCategoryController::class, 'edit']);
Route::post("intertext-category/update/{id}", [IntertextCategoryController::class, 'update']);
Route::get("intertext-category/create", [IntertextCategoryController::class, 'create']);
Route::post("intertext-category/store", [IntertextCategoryController::class, 'store']);


//Manage OriginalCodex Routes
Route::get("manuscript-original-codex", [ManuscriptOriginalCodexController::class, 'index']);
Route::get("manuscript-original-codex/show/{id}", [ManuscriptOriginalCodexController::class, 'show']);
Route::get("manuscript-original-codex/edit/{id}", [ManuscriptOriginalCodexController::class, 'edit']);
Route::post("manuscript-original-codex/update/{id}", [ManuscriptOriginalCodexController::class, 'update']);
Route::get("manuscript-original-codex/create", [ManuscriptOriginalCodexController::class, 'create']);
Route::post("manuscript-original-codex/store", [ManuscriptOriginalCodexController::class, 'store']);


// Hilfe-Bereich
Route::get("/help/oxygen-xml", [HilfeController::class, 'oxygenXml']);

Route::post("author/store", [CCRoleController::class, 'store']);
Route::put("author/store/{id}", [CCRoleController::class, 'store']);
Route::post("veranstaltung/store", [VeranstaltungController::class, 'store']);
Route::put("veranstaltung/store/{id}", [VeranstaltungController::class, 'store']);
Route::post("collegium-coranicum/store", [CollegiumCoranicumController::class, 'store']);
Route::put("collegium-coranicum/store/{id}", [CollegiumCoranicumController::class, 'store']);


Route::get('{category}/index',[GenericController::class,'index'])->name('index');
Route::get('{category}/show/{id}', [GenericController::class,'show' ])->name('show');
Route::get('{category}/edit/{id}',[GenericController::class,'edit'])->name('edit');
Route::get('{category}/create',[GenericController::class,'create'])->name('create');
Route::post('{category}/store',[GenericController::class,'store'])->name('store_new');
Route::put('{category}/store/{id}',[GenericController::class,'store'])->name('replace_existing');


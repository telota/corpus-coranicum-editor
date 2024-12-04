<?php

namespace App\Http\Controllers;

use App\Enums\FormAction;
use App\Models\Manuscripts\ManuscriptNew;
use App\Models\Manuscripts\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Models\Manuscripts\ManuscriptPageImage;
use App\Models\Manuscripts\ManuscriptPage;
use Illuminate\Support\Str;
use \Symfony\Component\HttpFoundation\File\UploadedFile;

class ManuscriptPageImageController extends Controller
{
    /**
     * Only allow access when logged in
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($manuscript_id, $page_id)
    {
        $page = ManuscriptPage::with('manuscript')->findOrFail($page_id);
        $image = new ManuscriptPageImage();
        $image->page_id = $page_id;
        $image->page = $page;

        return view('manuscript_page_image', [
            "action" => FormAction::Create,
            "formUrl" => action(
                [ManuscriptPageImageController::class, 'store'],
                compact('manuscript_id', 'page_id')
            ),
            "image" => $image,
            "other_images" => $page->images,
            "page" => $page,
        ]);
    }

    public function edit($manuscript_id, $page_id, $image_id)
    {
        $image = ManuscriptPageImage::with('page.manuscript')->findOrFail($image_id);
        $page = ManuscriptPage::findOrFail($page_id);

        return view('manuscript_page_image', [
            "action" => FormAction::Edit,
            "formUrl" => action(
                [ManuscriptPageImageController::class, 'store'],
                compact('manuscript_id', 'page_id', 'image_id')
            ),
            "image" => $image,
            "page" => $page,
            "other_images" => $page->images->filter(fn($i) => $i->id != $image_id),
        ]);
    }

    public function store(
        Request $request,
                $manuscript_id,
                $page_id,
                $image_id = null
    )
    {

        if ($request->file('single_file') !== null) {
            Log::info("Uploaded Manuscript file type: {$request->file('single_file')->getClientMimeType()}");
        }

        $request->validate([
            'single_file' => 'mimetypes:image/jpeg,image/jpg,image/png,image/tiff',
        ]);



        $manuscript = ManuscriptNew::findOrFail($manuscript_id);
        if($manuscript->no_images && $request->private_use_only != true){
            abort(400, "Image must be set to private use if manuscript doesn't allow images.");
        }
        if ($image_id) {
            $image = ManuscriptPageImage::findOrFail($image_id);
        } else {
            $image = new ManuscriptPageImage();
        }

        $images = ManuscriptPageImage::where('manuscript_page_id', $page_id)->get();
        $max_sort = isset($image_id) ? sizeof($images) : sizeof($images) + 1;

        if ($request->sort < 1) {
            $sort = 1;
        } elseif ($request->sort > $max_sort) {
            $sort = $max_sort;
        } else {
            $sort = $request->sort;
        };



        if ($image_id == null) {
            $existing = ManuscriptPageImage::where('manuscript_page_id', $page_id)
                ->orderBy('sort')
                ->get();

        } else {
            $existing = ManuscriptPageImage::where('manuscript_page_id', $page_id)
                ->where('id', '<>', $image_id)
                ->orderBy('sort')
                ->get();
        }

        $existing->splice($sort - 1, 0, [$image]);

        foreach ($existing as $index => $i){
            if(isset($i->id)){
                $i->sort = 100000 + $index + 1;
                $i->save();
            }
        }




        Log::info("Setting fields for manuscript image");

        $fields = [
            "private_use_only",
            "sort",
            "image_link_external",
            "credit_line_image",
            "iiif_external",
            "thumbnail_external",
        ];


        GenericController::mapRequestToModel($request, $image, $fields);

        $image->manuscript_page_id = $page_id;

        $image->save();

        $correct_the_sort = ManuscriptPageImage::where('manuscript_page_id', $page_id)
            ->where('sort', ">", 100000)
            ->get();

        foreach($correct_the_sort as $i){
           $i->sort = $i->sort - 100000;
           $i->save();
        }



        if ($request->hasFile('single_file')) {
            Log::info("Saving the file from the request: {$request->file('single_file')->getClientOriginalName()}");

            if (isset($image->image_link)) {
                self::deleteFile($image->image_link);
            }
            $savedFile = self::saveFile($manuscript_id, $page_id, $image->id, $request->file('single_file'));
            $image->image_link = $savedFile;
            $image->original_filename = $request->file('single_file')->getClientOriginalName();
        }

        $image->save();

        return redirect()->route('ms_page.show', ["manuscript_id" => $manuscript_id, "page_id" => $page_id]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
                $manuscript_id,
                $page_id,
                $image_id,
    )
    {

        $image = ManuscriptPageImage::findOrFail($image_id);
        if (isset($image->image_link)) {
            self::deleteFile($image->image_link);
        }

        $deleted_image_position = $image->sort;
        $image->delete();

        ManuscriptPageImage::where('manuscript_page_id', $page_id)
            ->where('sort', '>', $deleted_image_position)
            ->update(['sort' => DB::raw('sort - 1')]);

        return redirect()->route('ms_page.show', ["manuscript_id" => $manuscript_id, "page_id" => $page_id]);

    }

    public static function deleteFile($path)
    {
        if (env('APP_ENV') == 'local') {
            $disk = "local_digital_library";
        } else {
            $disk = 'digilib';
        }

        if (!Storage::disk($disk)->exists($path)) {
            Log::alert("File not found to delete: $path");
        }
        Storage::disk($disk)->delete($path);

        $segments = explode("/", $path);
        if(sizeof($segments) > 1 && Str::isUuid($segments[count($segments)-2])){
            $directory = substr($path, 0,strrpos($path, "/"));
            Log::info("Checking directory $directory to see if it is empty.");
            $files = Storage::disk($disk)->allFiles($directory);
            if(sizeof($files) == 0){
                Log::info("Deleting directory $directory because it contains no files.");
                Storage::disk($disk)->deleteDirectory($directory);
            }

        }

    }

    public static function createImageLocation(
        $manuscript_id,
        $page_id,
        $image_id,
        $extension,
    ): string
    {
        $filePath = self::createImagePath(
            $manuscript_id,
        );
        $filename = self::createImageName(
            $manuscript_id,
            $page_id,
            $image_id,
            $extension,
        );

        return $filePath . $filename;

    }

    public static function saveFile(
        $manuscript_id,
        $page_id,
        $image_id,
        UploadedFile $file
    )
    {
        Log::info("File received with original name: "
            . $file->getClientOriginalName());
        Log::info("File received with extension: "
            . $file->getClientOriginalExtension());

        $fileToSave = self::createImageLocation(
            $manuscript_id,
            $page_id,
            $image_id,
            $file->getClientOriginalExtension()
        );

        if (env('APP_ENV') == 'local') {
            $disk = "local_digital_library";
        } else {
            $disk = 'digilib';
        }

        $storagePath = Storage::disk($disk)->path('');
        Log::info("Here is the disk storage path: $storagePath");
        $subPath = substr($fileToSave, 0, strrpos($fileToSave, "/"));
        $fileName = substr($fileToSave, strrpos($fileToSave, "/") + 1);
        $fullPath = $storagePath . $subPath;
        Log::info("Saving $fileName to $fullPath");
        $file->move($fullPath, $fileName);

        return $fileToSave;
    }

    public static function createImageName(
        $manuscript_id,
        $page_id,
        $image_id,
        $extension
    ): string
    {

        $suffix = $extension == "" ? "" : ".$extension";
        return "manuscript-$manuscript_id-" .
            "page-$page_id-" .
            "image-$image_id" .
            $suffix;
    }


    public static function createImagePath(
        $manuscript_id
    ): string
    {

        $path_prefix = "";

        if (env('APP_ENV') == 'local') {
            $path_prefix = config('constants.local_file_directory');
        } else if (env('APP_ENV') == 'dev') {
            $path_prefix = config('constants.dev_file_directory');
        }

        return $path_prefix .
            "manuscript/$manuscript_id/" .
            Str::uuid() .
            "/";
    }

    public static function makeImageLink(?string $db_image_link, $fullscreen = false)
    {
        if ($db_image_link == null) {
            return null;
        }

        if (Str::startsWith($db_image_link, config('constants.local_file_directory'))) {
            return config('constants.local_digilib_url') . $db_image_link;
        }

        $width = $fullscreen ? 3000 : 400;

        return config('constants.digilib.base') .
            config('constants.digilib.scaler_path') .
            env("DIGILIB_DIR") .
            $db_image_link .
            '&dw=' . $width;
    }

}

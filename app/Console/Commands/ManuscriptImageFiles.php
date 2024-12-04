<?php

namespace App\Console\Commands;

use App\Models\Manuscripts\ManuscriptPageImage;
use App\Models\Manuscripts\Place;
use DOMDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ManuscriptImageFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:manuscript-image-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes an XML File describing the Manuscript Image Files.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $images = ManuscriptPageImage::with([
            'page:id,manuscript_id,folio,page_side',
            'page.manuscript:id,call_number,place_id',
            'page.manuscript.place:id,place,place_name,country_code'
        ])
            ->get();

        $xml = view('xml.manuscript_images', ['images' => $images])->render();
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . $xml;
        $dom = new DOMDocument('1.0','UFT-8');
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML(mb_convert_encoding($xml, 'UTF-8'));
        $dom->formatOutput = TRUE;
        Storage::put('images.xml', $dom->saveXML());
    }
}

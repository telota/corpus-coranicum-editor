<?php

namespace App\Models\Helpers;
use DOMDocument;
use DOMException;
use DOMXPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Session;

/**
 * Class ZoteroHelper
 * @package App\Models\Helpers
 */
class ZoteroHelper
{
    /**
     * Iterate over all fields and filter out all used Zotero IDs
     * @param Request $request
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Throwable
     */
    public static function extractZotero(Request $request)
    {
        $zoteroContent = json_decode(Storage::get("zotero/zoteroMapping.json"));
        $zoteroClass = "//a[contains(@class, 'zotero')]";
        $zoteroEntries = array();

        foreach ($request->except(["_token", "files", "updated_at", "Literatur"]) as $parameter => $content) {
            if (is_array($content)) {
                continue;
            }

            if (empty(strip_tags($content))) {
                continue;
            }

            $dom = new DOMDocument();

            try {
                @$dom->loadHTML($content);
            } catch (DOMException $e) {
                Session::flash("flash_type", "alert-warning");
                Session::flash("flash_message", "One or more fields could not be parsed by Zotero");
                continue;
            }


            $finder = new DOMXPath($dom);
            $zoteroNodes = $finder->query($zoteroClass);

            foreach ($zoteroNodes as $node) {
                $zoteroId = $node->getAttribute("zotero");
                if ($zoteroId) {
                    $zoteroCite = $zoteroContent->{$zoteroId}->long;
                    array_push($zoteroEntries, $zoteroCite);
                }
            }

        }

        $zoteroEntries = array_unique($zoteroEntries);

        natsort($zoteroEntries);

        $bibliographyList = view("includes.manuskript.literatur", [
            "zoteroItems" => $zoteroEntries,
        ])->render();

        return $bibliographyList;
    }
}

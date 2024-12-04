<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoteroBibliography extends Model
{
    use HasFactory;
    protected $table = 'zotero_bibliography';
    protected $primaryKey = 'zotero_key';
    public $incrementing = false;

    public static function forSummernote(){

        return self::select('zotero_key', 'citation', 'short_citation')->where('citation', '!=', '')->orderby('citation', 'asc')->get()
            ->map(function ($value) {
                return [
                    'zotero_key' => $value->zotero_key,
                    'citation' =>  html_entity_decode($value->citation),
                    'short_citation' =>  html_entity_decode($value->short_citation),
                ];
            });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Translation
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $key
 * @property string $de
 * @property string $en
 * @property string $fr
 * @property string $ar
 * @property string $fa
 * @property string $ru
 * @property string $tr
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereDe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereFa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereTr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereUserId($value)
 * @mixin \Eloquent
 */
class Translation extends Model
{
    public $table = "translations";

    protected $primaryKey = "key";
    protected $keyType = 'string';

    protected $fillable = ["key", "de", "en", "user_id"];

}

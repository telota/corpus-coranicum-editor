<?php

namespace App\Models\Lesarten;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Lesarten\LeserAlias
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $leser
 * @property string $alias
 * @method static \Illuminate\Database\Eloquent\Builder|LeserAlias whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeserAlias whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeserAlias whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeserAlias whereLeser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeserAlias whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeserAlias extends Model
{
    public $table = "lc_leser_alias";
}

<?php

namespace App\Models\Manuscripts;

use App\Models\Manuskripte\BelongsToManuskriptTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class ManuscriptAntiquityMarket extends Model
{
    use BelongsToManuskriptTrait;

    protected $table = "ms_manuscript_antiquity_markets";

    protected $guarded = ["id"];

    public $timestamps = true;

    /**
     * Get associated auction house
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function auctionHouse()
    {
        return $this->hasOne(AntiquityMarket::class, "id", "auction_house_id");
    }

    /**
     * Get associated manuscript
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function manuscript()
    {
        return $this->hasOne(ManuscriptNew::class, "id", "manuscript_id");
    }
}

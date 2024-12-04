<?php

namespace App\Console\Commands;

use App\Models\Manuscripts\ManuscriptNew;
use App\Models\Manuskripte\Manuskript;
use Illuminate\Console\Command;

class CountManuscripts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:count-manuscripts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $oldOnline = Manuskript::where("webtauglich", "ja")->get();
        $oldWithoutImages = Manuskript::where("webtauglich", "ohneBild")->get();

        $this->info("Old online with images: " . sizeof($oldOnline));
        $this->info("Old without Imgaes: " . sizeof($oldWithoutImages));

        $oldTotal = $oldOnline->concat($oldWithoutImages);
        $this->info("Old total: " . sizeof($oldTotal));


        $new = ManuscriptNew::where("is_online", ">", 0)->get();
        $this->info("Online Manuscripts new metadata structure: " . sizeof($new));


        $total = $new->pluck("id")->concat($oldTotal->pluck("ID"))->unique();

        $this->info("Total published manuscripts: " . sizeof($total));

        $this->info($total->sort());
        //
    }
}

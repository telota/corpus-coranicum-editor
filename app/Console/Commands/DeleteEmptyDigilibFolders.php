<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DeleteEmptyDigilibFolders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-empty-digilib-folders {folder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private function checkDirectory($folder)
    {
        $disk = Storage::disk("digilib");

        $directories = $disk->directories($folder);

        foreach ($directories as $directory) {
            $this->checkDirectory($directory);
        }

        //Don't check enormous folders
        if(sizeof($directories)>500){
            $this->info("Directory $folder has over 500 subdirectories. Skipping because it's too large...");
            return;
        }

        $allFiles = $disk->allFiles($folder);
        if (sizeof($allFiles) == 0) {
            $this->info("Directory $folder appears to be empty and is going to be deleted now.");
            $disk->deleteDirectory($folder);
        }else{
            $this->info("Directory $folder contains files and will not be deleted.");
        }

    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $folder = $this->argument("folder");
        $this->checkDirectory($folder);


    }
}

<?php

namespace App\Console\Commands;

use App\Models\KoranUebersetzung;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ImportParetUebersetzung extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'koran:import-uebersetzung {file} {json=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import or update Koran translations from a JSON file or excel file';


    private function getExcelData($filePath){
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($filePath);
        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();
        return collect($data)
            ->filter(function($value, $key){
                return $key != 0 && $value[4] != null;
            })->map(function($row){
                return [
                    'sure' => $row[0],
                    'vers' => $row[1],
                    'sprache' => $row[2],
                    'text' => $row[3]
                ];
            })->toArray();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the file path from the command argument
        $filePath = $this->argument('file');

        // Check if the file exists
        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        if($this->argument('json')=='true') {
            $jsonContent = file_get_contents($filePath);
            $data = json_decode($jsonContent, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->error('Invalid JSON format');
                return 1;
            }
        }else{
            $data = $this->getExcelData($filePath);
        }

        $this->info('Starting import...');

        // Loop through each record in the JSON file
        foreach ($data as $record) {
            // Ensure that each record contains 'sure' and 'vers' keys
            if (!isset($record['sure'], $record['vers'], $record['sprache'])) {
                $this->warn("Skipping record without 'sure' or 'vers': " . json_encode($record));
                continue;
            }

            // Update or create the record in the database
            KoranUebersetzung::updateOrCreate(
                [
                    'sure' => $record['sure'],
                    'vers' => $record['vers'],
                    'sprache' => $record['sprache']
                ],
                [
                    'text' => $record['text'] ?? null,
                ]
            );

            $this->info("Processed sure {$record['sure']} vers {$record['vers']} sprache {$record['sprache']}");
        }

        $this->info('Import completed successfully.');
        return 0;
    }
}
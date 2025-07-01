<?php

namespace App\Console\Commands;

use App\Models\Tender;
use Illuminate\Console\Command;

class ImportTenders extends Command
{
    protected $signature = 'import:tenders {path}';
    protected $description = 'Import tenders from CSV';

    public function handle()
    {
        $path = $this->argument('path');

        if (!file_exists($path)) {
            $this->error("File not found: $path");
            return;
        }

        $file = fopen($path, 'r');
        $header = fgetcsv($file, 0, ',');

        while (($row = fgetcsv($file, 0, ',')) !== false) {
            $data = array_combine($header, $row);

            Tender::updateOrCreate(
                ['external_code' => $data['Внешний код']],
                [
                    'number' => $data['Номер'],
                    'status' => $data['Статус'],
                    'name' => $data['Название'],
                    'updated_at_original' => \Carbon\Carbon::createFromFormat('d.m.Y H:i:s', $data['Дата изм.']),
                ]
            );
        }

        fclose($file);

        $this->info('Import complete');
    }

}

<?php

namespace App\Jobs;

use App\Models\Record;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;

class ImportCSVJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const BATCH = 1000;

    public function __construct(protected string $path) {}

    public function handle(): void {
        ini_set('memory_limit', '1024M');

        Log::debug('Initial memory usage: ' . floor(memory_get_usage() / (1024 * 1024)) . " MB");

        $stream = fopen(public_path($this->path), 'r');

        $reader = Reader::createFromStream($stream);
        $reader->setHeaderOffset(0);
        $batch = [];

        foreach ($reader->getRecords() as $index => $record) {
//            $record = array_map(fn ($item) => str_replace("'", '', $item), $record);
//            $batch[] = "('{$record['Customer Id']}', '{$record['First Name']}', '{$record['Last Name']}', '{$record['Company']}', '{$record['City']}', '{$record['Country']}', '{$record['Phone 1']}', '{$record['Phone 2']}', '{$record['Email']}', '{$record['Subscription Date']}', '{$record['Website']}')";
            $batch[] = [
                'customer_id' => $record['Customer Id'],
                'first_name' => $record['First Name'],
                'last_name' => $record['Last Name'],
                'company' => $record['Company'],
                'city' => $record['City'],
                'country' => $record['Country'],
                'phone_1' => $record['Phone 1'],
                'phone_2' => $record['Phone 2'],
                'email' => $record['Email'],
                'subscription_date' => $record['Subscription Date'],
                'website' => $record['Website'],
            ];

            if ($index % self::BATCH === 0) {
//                $values = implode(', ', $batch);
//                $sql = <<<SQL
//                    INSERT INTO records (customer_id, first_name, last_name, company, city, country, phone_1, phone_2, email, subscription_date, website)
//                    VALUES $values
//                SQL;
//
//                DB::statement($sql);
//                $batch = [];
//                unset($sql);
//                unset($values);
                Record::query()->insert($batch);
                $batch = [];

                Log::debug('Memory usage after batch insert: ' . floor(memory_get_usage() / (1024 * 1024)) . " MB");
            }
        }

        if (!empty($batch)) {
            Record::query()->insert($batch);
        }

        fclose($stream);

        Log::debug('Final memory usage: ' . floor(memory_get_usage() / (1024 * 1024)) . " MB");
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/quotes.json');

        if (! File::exists($path)) {
            $this->command->error('Could not find database/data/quotes.json, no quotes were seeded.');

            return;
        }

        $quotes = json_decode(File::get($path), true);

        if (! is_array($quotes)) {
            $this->command->error('database/data/quotes.json does not contain a valid JSON array.');

            return;
        }

        foreach ($quotes as $quote) {
            DB::table('quotes')->updateOrInsert(
                ['quote' => $quote['quote'] ?? ''],
                [
                    'author' => $quote['author'] ?? 'Unknown',
                    'source' => $quote['source'] ?? null,
                ],
            );
        }

        $this->command->info('Seeded '.count($quotes).' quotes.');
    }
}

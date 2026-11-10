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

        $quotes = json_decode(File::get($path), true);

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

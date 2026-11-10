<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $quotes = json_decode(Storage::disk('public')->get('quotes.json'), true);

        foreach ($quotes as $quote) {
            DB::table('quotes')->insert([
                'quote' => $quote['quote'],
                'author' => $quote['author'],
                'source' => $quote['source'],
            ]);
        }

    }
}

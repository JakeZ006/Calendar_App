<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote');
            $table->string('author')->default('Unknown');
            $table->string('source')->nullable();
        });

        $quotes = json_decode(Storage::disk('public')->get('quotes.json'), true);

        foreach ($quotes as $quote) {
            DB::table('quotes')->insert([
                'quote' => $quote['quote'],
                'author' => $quote['author'],
                'source' => $quote['source'],
            ]);
        }

    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};

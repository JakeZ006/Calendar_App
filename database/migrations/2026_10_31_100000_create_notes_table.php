<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('type');
            $table->boolean('important')->nullable();
            $table->boolean('expirable')->nullable();
            $table->string('content')->nullable();
            $table->timestamps();
            $table->date('for_date');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};

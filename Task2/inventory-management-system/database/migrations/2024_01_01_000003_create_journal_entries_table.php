<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Journal Entries Table
 * Stores double-entry accounting journal entries linked to sales.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('account_name');
            $table->decimal('debit', 12, 2)->default(0);
            $table->decimal('credit', 12, 2)->default(0);
            $table->unsignedBigInteger('reference_id')->nullable(); // sale_id
            $table->timestamps();

            $table->index('date');
            $table->index('reference_id');
            $table->index('account_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_entries');
    }
};

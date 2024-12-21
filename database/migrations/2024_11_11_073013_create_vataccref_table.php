<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vataccref', function (Blueprint $table) {
            $table->integer('Account_Ref_ID');
            $table->integer('VAT_ID');

            $table->primary(['Account_Ref_ID', 'VAT_ID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vataccref');
    }
};

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
        Schema::table('bankreconciliation', function (Blueprint $table) {
            $table->unsignedBigInteger('User_ID')->after('Bank_Recon_ID'); // Adjust position as needed
            $table->foreign('User_ID')->references('User_ID')->on('user')->onDelete('cascade');
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bankreconciliation', function (Blueprint $table) {
            $table->dropForeign(['User_ID']);
            $table->dropColumn('User_ID');
        });
    }
};

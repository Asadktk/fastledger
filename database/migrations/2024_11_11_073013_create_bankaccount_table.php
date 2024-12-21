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
        Schema::create('bankaccount', function (Blueprint $table) {
            $table->integer('Bank_Account_ID', true);
            $table->integer('Client_ID');
            $table->integer('Bank_Type_ID');
            $table->string('Bank_Name', 250);
            $table->string('Account_Name', 200)->nullable();
            $table->string('Account_No', 50)->nullable();
            $table->string('Sort_Code', 50)->nullable();
            $table->dateTime('Created_On')->nullable();
            $table->integer('Created_By')->nullable();
            $table->dateTime('Last_Modified_On')->nullable();
            $table->integer('Last_Modified_By')->nullable();
            $table->integer('Is_Deleted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bankaccount');
    }
};

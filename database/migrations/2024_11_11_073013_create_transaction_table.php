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
        Schema::create('transaction', function (Blueprint $table) {
            $table->integer('Transaction_ID', true);
            $table->dateTime('Transaction_Date');
            $table->integer('File_ID')->index('file_id');
            $table->integer('Bank_Account_ID')->nullable();
            $table->integer('Paid_In_Out')->comment('1: paid in
2: paid out');
            $table->integer('Payment_Type_ID')->index('payment_type_id');
            $table->integer('Account_Ref_ID')->nullable()->index('account_ref');
            $table->string('Cheque', 20)->nullable();
            $table->decimal('Amount', 12)->nullable();
            $table->string('Description', 500);
            $table->integer('Is_Imported')->nullable()->default(0)->comment('0: not imported yet
1: imported');
            $table->integer('Created_By')->nullable();
            $table->dateTime('Created_On')->nullable();
            $table->integer('Modified_By')->nullable();
            $table->dateTime('Modified_On')->nullable();
            $table->integer('Deleted_By')->nullable();
            $table->dateTime('Deleted_On')->nullable();
            $table->integer('VAT_ID')->nullable();
            $table->boolean('Is_Bill')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};

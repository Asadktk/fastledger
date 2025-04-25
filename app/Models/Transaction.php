<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'Transaction_ID';
    protected $fillable = [
        'Transaction_Date',
        'File_ID',
        'Bank_Account_ID',
        'Paid_In_Out',
        'Payment_Type_ID',
        'Account_Ref_ID',
        'Cheque',
        'Amount',
        'Description',
        'Is_Imported',
        'Created_By',
        'Created_On',
        'Modified_By',
        'Modified_On',
        'Deleted_By',
        'Deleted_On',
        'VAT_ID',
        'Is_Bill',
    ];

    public $timestamps = false;

    public function getBankAccountNameAttribute()
    {
        return $this->bankAccount ? $this->bankAccount->Account_Name : null;
    }


    public function file()
    {
        return $this->belongsTo(File::class, 'File_ID');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'Bank_Account_ID');
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'Payment_Type_ID');
    }

    public function accountRef()
    {
        return $this->belongsTo(AccountRef::class, 'Account_Ref_ID');
    }

    public function vatType()
    {
        return $this->belongsTo(VatType::class, 'VAT_ID');
    }

    // In your Transaction model
    public function scopeActive($query)
    {
        return $query->whereNull('Transaction.Deleted_On')
            ->where('Transaction.Is_Imported', 1)
            ->where('Transaction.Is_Bill', 0);
    }

    public function bankReconciliation()
    {
        return $this->hasOne(BankReconciliationDetail::class, 'Transaction_ID', 'Transaction_ID');
    }
}

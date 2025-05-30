<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = 'bankaccount';
    protected $primaryKey = 'Bank_Account_ID';

    protected $fillable = ['Account_Name', 'Bank_Type_ID', 'Bank_Name', 'Account_No', 'Sort_Code'];

    public function bankAccountType()
    {
        return $this->belongsTo(BankAccountType::class, 'Bank_Type_ID', 'Bank_Type_ID');
    }

    public function accountRefs()
    {
        return $this->hasMany(AccountRef::class, 'Bank_Type_ID');
    }

     public function fetchAll($clientId, $bankTypeId = null)
    {
        $query = self::where('Client_ID', $clientId);

        if ($bankTypeId) {
            $query->where('Bank_Type_ID', $bankTypeId);
        }

        return $query->orderBy('Bank_Name', 'asc')->get();
    }
}

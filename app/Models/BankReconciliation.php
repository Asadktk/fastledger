<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankReconciliation extends Model
{
    protected $table = 'bankreconcilation';
    protected $primaryKey = 'Bank_Recon_ID';

    protected $fillable = [
        'Amount',
        'Transaction_Date',
        'User_ID',
    ];
    


}

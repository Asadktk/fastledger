<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VatType extends Model
{
    protected $table = 'vattype';
    protected $primaryKey = 'VAT_ID';

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'VAT_ID', 'VAT_ID');
    }
}

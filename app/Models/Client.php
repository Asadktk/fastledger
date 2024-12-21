<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'client';
    protected $primaryKey = 'Client_Id';
    protected $fillable = [
        'client_ref',
        'contact_name',
        'business_name',
        'address1',
        'address2',
        'town',
        'country_id',
        'post_code',
        'phone',
        'mobile',
        'fax',
        'email',
        'company_reg_no',
        'vat_registration_no',
        'contact_no',
        'fee_agreed',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'deleted_by',
        'deleted_on',
        'is_archive'
    ];

    public $timestamps = false;
    protected $dates = ['created_on', 'modified_on', 'deleted_on'];

    // public function country()
    // {
    //     return $this->belongsTo(Country::class);
    // }

    public function scopeNotArchived($query)
    {
        return $query->where('is_archive', 0);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archive', 1);
    }

    public function files()
    {
        return $this->hasMany(File::class, 'Client_ID', 'Client_ID'); // Match 'Client_ID' in 'files' table
    }
    public function users()
    {
        return $this->hasMany(User::class, 'Client_ID', 'Client_ID');
    }
}

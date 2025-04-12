<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'client';
    protected $primaryKey = 'Client_Id';
    protected $fillable = [
        'Client_ID',
        'Client_Ref',
        'Contact_Name',
        'Business_Name',
        'Address1',
        'Address2',
        'Town',
        'Country_ID',
        'Post_Code',
        'Phone',
        'Mobile',
        'Fax',
        'Email',
        'Company_Reg_No',
        'VAT_Registration_No',
        'Contact_No',
        'Fee_Agreed',
        'Created_By',
        'Created_On',
        'Modified_By',
        'Modified_On',
        'Deleted_By',
        'Deleted_On',
        'Is_Archive',
        'date_lock',
        'transaction_lock'
    ];

    public $timestamps = false;

    protected $dates = [
        'Created_On',
        'Modified_On',
        'Deleted_On',
        
    ];



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

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}

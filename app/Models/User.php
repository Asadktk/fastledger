<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Define the table associated with the model
    protected $table = 'user';
    protected $primaryKey = 'User_ID';
    public $incrementing = true;

    // Fillable attributes (columns you can mass assign)
    protected $fillable = [
        'Full_Name',
        'User_Name',
        'email',
        'password',
        'Is_Active',
        'Sys_IP',
        'Last_Login_DateTime',
        'User_Role',
        'Client_ID',
        'Created_By',
        'Modified_By',
        'Deleted_By',
        'Deleted_On',
        'Is_Archive',
    ];

    // Custom timestamp columns
    const CREATED_AT = 'Created_On';
    const UPDATED_AT = 'Modified_On';

    // Hide sensitive information like password
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casts for certain attributes
    protected $casts = [
        'Last_Login_DateTime' => 'datetime', // Cast the date column to a Carbon instance
    ];


 

    // Define the relationship with the Client model (if needed)
    public function client()
    {
        return $this->belongsTo(Client::class, 'Client_ID', 'Client_ID');
    }

    // Define the relationship with the Role model (if needed)
    public function role()
    {
        return $this->belongsTo(Role::class, 'User_Role', 'Role_ID');
    }

   
}

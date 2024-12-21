<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'Role_ID';
    public $timestamps = false;

    protected $fillable = ['Role_Name', 'Description'];

    const SUPER_ADMIN = 'superadmin';
    const ADMIN = 'admin';
    const CLIENT = 'client';

    public function users()
    {
        return $this->hasMany(User::class, 'User_Role', 'Role_ID');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = "users_roles";

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    public function rolePermission()
    {
        return $this->hasMany('App\Models\RolePermission','role_id','role_id');
    }
}

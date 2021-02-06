<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $table = "roles_permissions";

    protected $fillable = [
        'role_id',
        'permission_id',
    ];

    public function singlePermission()
    {
        return $this->hasOne('App\Models\Permission','id','permission_id');
    }

    public function permissions()
    {
        return $this->hasMany('App\Models\Permission','id','permission_id');
    }
}

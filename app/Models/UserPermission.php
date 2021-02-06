<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $table = "users_permissions";

    public function slug()
    {
        return $this->hasOne('App\Models\Permission','id','permission_id');
    }
}

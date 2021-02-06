<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function roles() {
        return $this->belongsToMany(Role::class,'roles_permissions');
    }
     
    public function users() {
        return $this->belongsToMany(User::class,'users_permissions');
    }

    public function countFilterRecords($searchValue)
    {
        $fetchUsers = $this->select('count(*) as allcount')
            ->where('name', 'like', '%' . $searchValue . '%')
            ->orWhere('slug', 'like', '%' . $searchValue . '%')
            ->count();
        return $fetchUsers;
    }

    public function fetchFilterRecord($columnName,$columnSortOrder,$searchValue,$start,$rowperpage)
    {
        $fetchFilterUsers = $this->orderBy($columnName, $columnSortOrder)
            ->where('permissions.name', 'like', '%' . $searchValue . '%')
            ->orWhere('permissions.slug', 'like', '%' . $searchValue . '%')
            ->select('permissions.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        return $fetchFilterUsers;
    }
}

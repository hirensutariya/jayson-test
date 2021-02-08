<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = "roles";
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

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
            ->where('roles.name', 'like', '%' . $searchValue . '%')
            ->orWhere('roles.slug', 'like', '%' . $searchValue . '%')
            ->select('roles.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        return $fetchFilterUsers;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = "departments";
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'created_at'
    ];
    public function checkDepartmentExist($requestData)
    {
        return $this->where('name',$requestData['name'])->first();
    }

    public function countFilterRecords($searchValue)
    {
        $fetchDepartment = $this->select('count(*) as allcount')
            ->where('name', 'like', '%' . $searchValue . '%')
            ->count();
        return $fetchDepartment;
    }

    public function fetchFilterRecord($columnName,$columnSortOrder,$searchValue,$start,$rowperpage)
    {
        $fetchFilterCountries = $this->orderBy($columnName, $columnSortOrder)
            ->where('departments.name', 'like', '%' . $searchValue . '%')
            ->select('departments.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        return $fetchFilterCountries;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Countries extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'countries';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'code',
        'created_at'
    ];


    public function states(){
        return $this->hasMany(States::class);
    }

    public function statesWithCities(){
        return $this->states()->with('cities');
    }

    public function checkExist($requestData)
    {
        return $this->where('name',$requestData['name'])->where('code',$requestData['code'])->first();
    }

    public function countFilterRecords($searchValue)
    {
        $fetchCountries = $this->select('count(*) as allcount')
            ->where('name', 'like', '%' . $searchValue . '%')
            ->orWhere('code', 'like', '%' . $searchValue . '%')
            ->count();
        return $fetchCountries;
   }

    public function fetchFilterRecord($columnName,$columnSortOrder,$searchValue,$start,$rowperpage)
    {
        $fetchFilterCountries = $this->orderBy($columnName, $columnSortOrder)
            ->where('countries.name', 'like', '%' . $searchValue . '%')
            ->orWhere('countries.code', 'like', '%' . $searchValue . '%')
            ->select('countries.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        return $fetchFilterCountries;
   }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;
    protected $table = 'cities';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'state_id',
        'name',
        'created_at'
    ];

    public function state(){
        return $this->belongsTo(States::class);
    }

    public function checkStateExist($requestData)
    {
        return $this->where('name',$requestData['name'])
            ->where('state_id',$requestData['state'])->first();
    }

    public function countFilterRecords($searchValue)
    {

        $fetchCities = Cities::select('count(*) as allcount')->with('state')->where(function ($query) use ($searchValue) {
            $query->where('name', 'LIKE', '%' . $searchValue . '%');
            $query->orWhereHas('state', function ($q) use ($searchValue) {
                $q->where(function ($q) use ($searchValue) {
                    $q->where('name', 'LIKE', '%' . $searchValue . '%');
                });
            });

        });
        $fetchCities = $fetchCities->count();
        return $fetchCities;
    }

    public function fetchFilterRecord($columnName,$columnSortOrder,$searchValue,$start,$rowperpage)
    {
        $fetchFilterCities = Cities::with('state')->orderBy($columnName, $columnSortOrder)
            ->where('cities.name', 'like', '%' . $searchValue . '%')
            ->orWhereHas('state', function ($q) use($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%');
            })
            ->select('cities.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        return $fetchFilterCities;
    }

}

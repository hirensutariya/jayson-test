<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class States extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;
    protected $table = 'states';
     protected $primaryKey = 'id';
    protected $fillable = [
        'country_id',
        'name',
        'created_at'
    ];

    public function cities()
    {
        return $this->hasMany(Cities::class);
    }

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }

    public function checkStateExist($requestData)
    {
        return $this->where('name', $requestData['name'])->where('country_id', $requestData['country'])->first();
    }

    public function countFilterRecords($searchValue)
    {
        $fetchStates = States::select('count(*) as allcount')->with('country')->where(function ($query) use ($searchValue) {
            $query->where('name', 'LIKE', '%' . $searchValue . '%');
            $query->orWhereHas('country', function ($q) use ($searchValue) {
                $q->where(function ($q) use ($searchValue) {
                    $q->where('name', 'LIKE', '%' . $searchValue . '%');
                });
            });

        });
        $fetchStates = $fetchStates->count();
        return $fetchStates;
    }

    public function fetchFilterRecord($columnName, $columnSortOrder, $searchValue, $start, $rowperpage)
    {
        $fetchFilterStates = States::with('country')->orderBy($columnName, $columnSortOrder)
            ->where('states.name', 'like', '%' . $searchValue . '%')
            ->orWhereHas('country', function ($q) use($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%');
            })
            ->select('states.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        return $fetchFilterStates;
    }


}

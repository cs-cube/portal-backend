<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Department extends BaseModel
{
    protected $fillable = [
        'name',
        'code',
        'college_id'
    ];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }


    public function scopeSearch(Builder $query, $q){
        $q = $this->trimParamater($q);

        if(!$q)
            return $query;

        return $query->where(function($query) use ($q){
            $query->where(DB::raw('LOWER(name)'), 'LIKE', "%$q%")
                    ->orWhere(DB::raw('LOWER(code)'), 'LIKE', "%$q%");
        });

    }
}

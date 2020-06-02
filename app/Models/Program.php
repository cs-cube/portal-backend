<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Program extends BaseModel
{
    protected $fillable = [
        'name',
        'code',
        'department_id',
        'no_of_years'
    ];


    public function scopeSearch(Builder $query, $q){
        $q = $this->trimParamater($q);

        if(!$q)
            return $query;

        return $query->where(function($query) use ($q){
            $query->where(DB::raw('LOWER(name)'), 'LIKE', "%$q%")
                    ->orWhere(DB::raw('LOWER(code)'), 'LIKE', "%$q%");
        });

    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}

<?php

namespace App\Models;

use App\Events\ModelEvents\Student\StudentCreated;
use App\Events\ModelEvents\Student\StudentCreating;
use App\Events\ModelEvents\Student\StudentUpdated;
use App\User;
use Illuminate\Database\Eloquent\Builder;


class Student extends BaseModel
{
    protected $fillable = [
        'id_number',
        'firstname',
        'lastname',
        'middlename',
        'user_id',
        'program_id',
        'year_level',
        'current_address',
        'home_address'
    ];

    protected $sortable = [
        'id_number',
        'fullname',
        'program',
        'year_level'
    ];

    public $dispatchesEvents = [
        'creating' => StudentCreating::class,
        'created' => StudentCreated::class,
        'updated' => StudentUpdated::class 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function scopeSearch(Builder $query, $q){
        $q = $this->trimParamater($q);

        if(!$q)
            return $query;


        return $query->where(function($query) use ($q){
            $query->whereRaw("LOWER(firstname) LIKE '$q%'")
                    ->orWhereRaw("LOWER(lastname) LIKE '$q%'");
        });
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function scopeSort(Builder $q){
        if($this->sortDir)
            switch($this->sortBy){
                case 'id_number':
                    $q->orderBy('id_number', $this->sortDir);
                    break;
                case 'fullname':
                    $q->orderBy('lastname', $this->sortDir)
                        ->orderBy('firstname', 'asc');
                    break;
                case 'program':
                    $q->join('programs', 'programs.id','=', 'students.program_id')
                        ->orderBy('programs.code', $this->sortDir);
                    break;
                case 'year_level':
                    $q->orderBy('year_level', $this->sortDir);
                    break;
            }
    }
}

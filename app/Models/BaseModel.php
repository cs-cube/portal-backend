<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $isPostgres;

    protected $sortBy = null;
    protected $sortDir = null;

    const SORT_KEY = 'sort_by';
    const SORT_DIR = 'sort_dir';

    protected $sortable = [];

    // public static function like(){
    //     return env('DB_CONNECTION') == 'pgsql'
    //             ? 'ILIKE'
    //             : 'LIKE';
    // }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->isPostgres = env('DB_CONNECTION') == 'pgsql';

        $this->checkSortRequest();

    }

    public function trimParamater($str){
        return str_replace("'", '', strtolower(trim($str)));
    }

    private function checkSortRequest(){
        $sortBy = request(self::SORT_KEY);
        
        $this->sortBy = array_search($sortBy, $this->sortable) != false
                            ? $sortBy
                            : null;

        if($this->sortBy)
            $this->sortDir = request(self::SORT_DIR) == 'asc'
                                ? 'asc'
                                : 'desc';


    }
}

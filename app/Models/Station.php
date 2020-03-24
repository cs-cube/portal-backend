<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{

    protected $appends = [ 'current_session', 'previous_session', 'service_types' ];

    public function getCurrentSessionAttribute(){
        return $this->usage_logs()->activeSessions()->with('user')->first();
    }

    public function getServiceTypesAttribute(){
        return ServiceTransaction::TYPES;
    }

    public function getPreviousSessionAttribute(){
        return $this->usage_logs()->inactiveSessions()->with('user')->latest()->first();
    }

    public function usage_logs()
    {
        return $this->hasMany(StationUsageLog::class);
    }
}
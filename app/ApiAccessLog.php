<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiAccessLog extends Model
{
    protected $table = 'api_access_log';
    
    protected $fillable = [
        'ip',
        'full_url',
        'type'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'client_id',
        'notes',
    ];

    protected $appends = [
        'url',
    ];

    public function getUrlAttribute()
    {
        return "/clients/" . $this->client_id . "/journals/";
    }
   
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopicItem extends Model
{

     protected $fillable = [
        'app_id',
        'order',
    ];
}

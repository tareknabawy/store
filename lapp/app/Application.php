<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Application extends Model
{
    use Sluggable;
    use \Conner\Tagging\Taggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $fillable = [
        'title',
        'description',
        'details',
        'image',
        'slug',
        'file_size',
        'license',
        'developer',
        'url',
        'buy_url',
        'type',
        'counter',
        'category',
        'platform',
        'tags',
        'owner_id'
    ];



}

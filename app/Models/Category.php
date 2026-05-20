<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'categories';

    protected $fillable = ['name', 'slug', 'icon', 'description'];

    public function events()
    {
        return $this->hasMany(Event::class, 'category_id');
    }
}

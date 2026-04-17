<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'slug', 'description', 'banner_url'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

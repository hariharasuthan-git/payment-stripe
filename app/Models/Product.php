<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'description',  'price',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status'    =>  'boolean',
    ];

     /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
    }

}

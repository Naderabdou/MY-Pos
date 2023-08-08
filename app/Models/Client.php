<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'phone' => 'array'
    ];
    //relation between client and order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }//end of orders
    //name attribute
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }//end of get name attribute



}

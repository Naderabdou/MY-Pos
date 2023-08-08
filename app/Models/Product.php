<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
class Product extends Model implements TranslatableContract

{
    use Translatable;

    use HasFactory;

    protected $guarded = [];
    public $translatedAttributes = ['name', 'description'];
    protected $appends = ['image_path', 'profit_percent'];

    public function getProfitPercentAttribute()
    {
        $profit = $this->sale_price - $this->purchase_price;
        $profit_percent = $profit * 100 / $this->purchase_price;
        //check if profit percent minus
        if ($profit_percent < 0) {
            return 0;
        }
        return number_format($profit_percent, 2);

    }//end of get profit attribute

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //get name of image
    public function getImagePathAttribute()
    {
        return asset('uploads/products_images/' . $this->image);



    }//end of image path attribute
    //relation between product and order
    public function orders()
    {
        return $this->belongsToMany(Order::class,'product_order')->withPivot('quantity');
    }//end of orders
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    
    protected $table = 'product_attributes';

    
    protected $fillable = ['attribute_id','value' ,'product_id', 'quantity'];

    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

 
public function attributesValues()
{
    return $this->belongsToMany(AttributeValue::class);
}

 
public function attribute()
{
    return $this->belongsTo(Attribute::class);
}
}
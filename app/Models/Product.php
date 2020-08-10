<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;

use App\Filters\ProductFilter;

use Illuminate\Database\Eloquent\Builder;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Product extends Model implements Searchable
{
    use Rateable;


    
    protected $table = 'products';

   
    protected $fillable = [
        'brand_id','category_id',  'name',  'slug','description', 'quantity',
         'price', 'sale_price' ,'featured','shipping'
    ];

   
    protected $casts = [
        'quantity'  =>  'integer',
        'brand_id'  =>  'integer',
        'category_id'=>  'integer',
        'featured'  =>  'boolean'

    ];

     
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }


     
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

  
public function images()
{
    return $this->hasMany(ProductImage::class);
}

 
public function attributes()
{
    return $this->hasMany(ProductAttribute::class);
}

 

public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
  
    

    public function scopeFilter(Builder $builder, $request)
    {
        return (new ProductFilter($request))->filter($builder);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }



    public function getSearchResult(): SearchResult
    {
        $url = route('product.show', $this->slug);
      
        return new SearchResult(
            $this,
            $this->slug,
            $url
           
        );
    }
}
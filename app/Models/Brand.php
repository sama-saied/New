<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
/**
 * Class Brand
 * @package App\Models
 */
class Brand extends Model implements Searchable
{
     
    protected $table = 'brands';

     
    protected $fillable = ['name','slug', 'logo'];

    
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str::slug($value);
    }

  
public function products()
{
    return $this->hasMany(Product::class);
}

public function getSearchResult(): SearchResult
{
    $url = route('brand.show', $this->slug);
  
    return new SearchResult(
        $this,
        $this->slug,
        $url
      
    );
}

}
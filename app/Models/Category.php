<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
use Illuminate\Support\Str;
use TypiCMS\NestableTrait;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;



class Category extends Model implements Searchable
{
   use NestableTrait;

    protected $table = 'categories';


    protected $fillable = [
        'name', 'slug','parent_id','image' ,  'featured',
    ];

    protected $casts = [
        'parent_id' =>  'integer',
    
        'featured'  =>  'boolean'
    ];


    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str::slug($value);
    }

    public function parent()
{
    return $this->belongsTo(Category::class, 'parent_id');
}

public function children()
{
    return $this->hasMany(Category::class, 'parent_id');
}
   
 

public function products()
{
    return $this->hasMany(Product::class);
}

public function getSearchResult(): SearchResult
{
     if($this->parent_id == 1)
     {
         
        $url = route('category.showw', $this->slug);
        return new SearchResult(
            $this,
            $this->slug,
            $url
        );
     }
     else{
    $url = route('category.show', $this->slug);
    return new SearchResult(
        $this,
        $this->slug,
        $url
    );
     }
}

}
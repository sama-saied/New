<?php


namespace App\Http\Controllers\Site;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Http\Controllers\Controller;


class SearchController extends Controller
{
    
    public function search( Request $request)
    {
        

        $searchterm = $request->input('query');
       
 
        $searchResults = (new Search())
                    ->registerModel(\App\Models\Product::class, 'name')
                    ->registerModel(\App\Models\Category::class, 'name')
                    ->registerModel(\App\Models\Brand::class, 'name')
                    ->perform($searchterm);
                            
    return view('site.pages.search', compact('searchResults', 'searchterm'/*,'image'*/));
    
}

   
}

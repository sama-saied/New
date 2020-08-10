<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class RatingController extends Controller
{


 public function __construct()
  {
   $this->middleware('auth');
  }



 public function productProduct(Request $request )
  {
    
   request()->validate(['rate' => 'required']);
   $product = Product::find($request->id);
  
   $rating = new \willvincent\Rateable\Rating;
   $rating->rating = $request->rate;
   $rating->user_id = auth()->user()->id;
   $product->ratings()->save($rating);
   return redirect()->back();
   
  }
}


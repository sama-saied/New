<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Cart_storage;
use App\Models\OrderItem;
use GuzzleHttp\Psr7\Request;

class Cartt extends Model 
{
    protected $table = 'cart';


    protected $fillable = [
        'user_id','name','qty','product_id','price','img'    ];
 
        
    public static function add($id, $name = null, $price = null, $quantity = null,$productImg = null)
    {

       $cart = new self();

        $cart->user_id = Auth::user()->id;
        $cart->product_id = $id;
        $cart->name = $name;
        $cart->price = $price;
        $cart->qty = $quantity;
        $cart->img = $productImg;
      
        $cart->save();
    }

    public static function addattr($key,$value,$id)
    {
       // $id = $id + 1;
        $cartt = new Cart_storage;
        $cartt->cart_id = $id;
        $cartt->key_name = $key;
        $cartt->value = $value;
        $cartt->save();
    }
    
     

    public static function getTotal($id)
    {
        $count = 0;
        $carts = Cartt::all();
        $pros = Product::all();
        foreach($carts as $cart)
        {
            if($cart->user_id == $id)
          foreach($pros as $pro){
              if($pro->id == $cart->product_id)
                {
                    if($pro->sale_price)
                    $count += $pro->sale_price * $cart->qty;
                    else
                 $count += $pro->price * $cart->qty;
                }
        }
        }

       return $count;
    }


    /**
     * check if cart is empty
     *
     * @return bool
     */
    public static function isEmpty($id)
    {
        $count = 0;
        $carts = Cartt::all();
        foreach($carts as $cart)
        {
            if($cart->user_id == $id)
            $count++;
        }
        
        if($count > 0)
        $b = true;
        else
        $b = false;

        return $b;
    }

    
    public function  user()
    {
        return $this->belongsTo(User::class);
    }

    public static function Counter($id)
    {
       $carts = Cartt::all();
       $count=0;
       foreach($carts as $cart)
       {
           if($cart->user_id == $id)
           $count++;
       }
       return $count;
    }
 

    public static function numbber($id)
    {
       $carts = Cartt::all();
       $qt=0;
       $ud = auth()->user()->id;

       foreach($carts as $cart)
       {
           if($cart->user_id == $ud)
          {
              if($cart->product_id == $id)
              {
                  $qt += $cart->qty; 
              }
          }
       }
       return $qt;
    }


    public static function getContent($id)
    {
        $carts = Cartt::all();
        $pro = Product::all();
        $total = Cartt::getTotal($id);
       return [$carts,$pro,$total];
    }

    public static function getContents()
    {
        $carts = Cartt::all();
        
       return $carts;
    }

    public static function getattr()
    {
        $attr = Cart_storage::all();
        return $attr;
    }

    public static function getContentt()
    {
        $items = OrderItem::all();
        return $items;
    }

  
    public static function upda($qty,$id)
    {
        $carts = Cartt::all();
        $ud = Auth::user()->id;
        foreach($carts as $cart)
        {
            if($cart->user_id == $ud && $cart->product_id == $id)
            {

               // $cart->qty = $cart->qty + $qty;

                $c = $cart->qty;
                $cart->qty = $c + $qty;

                $cart->save();
            }
        }
    }
/**
     * check if cart is empty
     *
     * @return bool
     */
    public static function check($id,$k)
    {
        $carts = Cartt::all();
        $ud = Auth::user()->id;
        $y = 0;
        foreach($carts as $cart)
        {
            if($cart->user_id == $ud && $cart->product_id == $id)
            {
                $y = 1;
            }
        }

        if($k)
        $s = true;
        elseif($y < 1 && !$k)
        $s = true;
        else
        $s = false;

    return $s;
    }

    public static function ClearCart($id)
 {
    $carts = Cartt::all();
    $attrs = Cart_storage::all();

    
    
     foreach($carts as $cart)
    {
        foreach($attrs as $attr)
    {
        if($attr->cart_id == $cart->id)
          $attr->delete();

    }

       if($cart->user_id == $id)
       $cart->delete();
   
}
     
 }

 public function values()
    {
        return $this->hasMany(Cart_storage::class);
}

}
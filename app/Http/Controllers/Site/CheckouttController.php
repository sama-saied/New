<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Contracts\OrderContract;
use App\Contracts\ProductContract;
use App\Http\Controllers\Controller;

use App\Models\Order;
use Darryldecode\Cart\Facades\CartFacade;
use  Cart;
Use  App\Models\Product;
use  App\Models\Cartt;
use  App\Models\Cart_storage;
use  App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;

class CheckouttController extends Controller
{
    protected $orderRepository;
    protected $ProductRepository;
    

    public function __construct(OrderContract $orderRepository,ProductContract $productRepository)
{
     
    $this->orderRepository = $orderRepository;
    $this->productRepository = $productRepository;
}


  public function getOrder()
  {
      $id = auth()->user()->id;
      if (Cartt::isEmpty($id) == false ){
          return redirect()->back()->with('message', 'Cart Is Empty.');
      }
      
      else
      {
        $carts = Cartt::all();
        $pro = Product::all();
        $total = Cartt::getTotal($id);
        $attr = Cart_storage::all();
        $pro_attr = ProductAttribute::all();

        $id = auth()->user()->id;

        foreach($carts as $cart)
        {  
            if($cart->user_id == $id)
            {
                $c = Cartt::numbber($cart->product_id);
               
                $p = $this->productRepository->findProductById($cart->product_id);

                if($c > $p->quantity)
                {
                    return view('site.pages.errormessage',compact('p'));

                }

            }
        }
  
            return view('site.pages.checkouttDisplay',compact('carts','pro','total','attr'));
        

      }
    }


    public function placeOrder(Request $request)
{
   
    $order = $this->orderRepository->storeOrderDettails($request->all());

    $id = auth()->user()->id;

    Cartt::ClearCart($id);

return view('site.pages.success', compact('order'));

}


}
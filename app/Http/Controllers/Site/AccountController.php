<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



use App\Contracts\OrderContract;
//use App\Http\Controllers\BaseController;



class AccountController extends Controller
{
    

    protected $orderRepository;

    public function __construct(OrderContract $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getOrders()
    {
        $orders = auth()->user()->orders;

        return view('site.pages.account.orders', compact('orders'));
    }


    public function delete($id)
{
    $order = $this->orderRepository->deleteOrder($id);
    return back();

}

}
<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Traits\OrderTrait;
use App\Traits\PermissionTrait;
use Illuminate\Http\Request;

class OrderController extends Controller

{
    use OrderTrait;
    use PermissionTrait;
    public function __construct()
    {
        $this->model = 'order';
        $this->permission($this->model);
    }
    public function index()
    {
        return view('dashboard.clients.orders.index');
    }
    public function create(Client $client)

    {
        $orders=$client->orders()->with('products')->paginate(5);
        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.create',compact('client','categories' ,'orders'));
    }
    public function store(OrderStoreRequest $request,Client $client)
    {
        $this->attach_order($request,$client);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');




    }
    public function edit(Client $client,Order $order)
    {
       $categories = Category::with('products')->get();
       $orders=$client->orders()->with('products')->paginate(5);
        return view('dashboard.clients.orders.edit',compact('client','order','categories','orders'));
    }
    public function update(OrderStoreRequest $request,Client $client,Order $order)
    {
        $this->detach_order($order);
        $this->attach_order($request,$client);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');
    }


    public function destroy(Client $client,Order $order)
    {

    }


}

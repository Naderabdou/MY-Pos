<?php
namespace App\Traits;
use App\Http\Requests\UserStoreRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait OrderTrait
{
    //function search

    private function attach_order($request,$client)
    {
        $data = $request->validated();
        $order = $client->orders()->create([]);
        $order->products()->attach($data['products']);
        $price=0;
        foreach ($data['products'] as $id => $quantities) {
            $product=Product::findorFail($id);
            $price+=$product->sale_price * $quantities['quantity'];
            $product->update(['stock'=>$product->stock-$quantities['quantity']]);
        }
        $order->update(['total_price'=>$price]);
    }
    public function detach_order($order)
    {

        foreach ($order->products as $product) {
            $product->update(['stock'=>$product->stock+$product->pivot->quantity]);
        }
        $order->delete();
    }


}

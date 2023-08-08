<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        //get count of all models
        $users_count=User::role('admin')->count();
        $categories_count=Category::count();
        $products_count=Product::count();
        $clients_count=Client::count();
        $orders_count=Order::count();
        $sales_data=Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as total_price')
        )->groupBy('year','month')->get();




        return view('dashboard.index', compact('users_count','categories_count','products_count','clients_count','orders_count','sales_data'));

    }
}

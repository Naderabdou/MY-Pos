<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Traits\PermissionTrait;
use App\Traits\ProductTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    use ProductTrait,PermissionTrait;
    public function __construct()
    {
        $this->model = 'product';
        $this->permission($this->model);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories=Category::all();
        $products=self::search($request);
        return view('dashboard.products.index',compact('categories','products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::all();
        return view('dashboard.products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
       $data= $request->validated();
       $request->except(['image']);
        if ($request->image) {
            self::uploadImage($request);
            $data['image'] = $request->image->hashName();
        }

        Product::create($data);
        session()->flash('success',__('site.added_successfully'));

        return redirect()->route('dashboard.products.index');
    }

    /**
     * Display the specified resource.
     */

    public function edit(Product $product)
    {
        $categories=Category::all();
        return view('dashboard.products.edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $data= $request->validated();

        if ($request->image) {


            if ($product->image != 'default.png') {
                self::deleteImage($product);

            }//end of if
            self::uploadImage($request);
            $data['image'] = $request->image->hashName();

        }

            $product->update($data);
        session()->flash('success',__('site.updated_successfully'));

        return redirect()->route('dashboard.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image != 'product.png') {
            self::deleteImage($product);

        }//end of if
        $product->delete();
        session()->flash('success',__('site.deleted_successfully'));

        return redirect()->route('dashboard.products.index');
    }
}

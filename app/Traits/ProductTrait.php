<?php
namespace App\Traits;
use App\Http\Requests\UserStoreRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait ProductTrait
{
    //function search


    public function __construct($model)



    {
        $this->model = $model;

        $this->middleware('permission:'.$model.'_read')->only(['index']);
         $this->middleware('permission:'.$model.'_create')->only(['create','store']);
            $this->middleware('permission:'.$model.'_update')->only(['edit','update']);
            $this->middleware('permission:'.$model.'_delete')->only(['destroy']);


    }



    public static function  search(Request $request)
    {
        return Product::when($request->search,function ($q) use ($request){
            return $q->whereTranslationLike('name','%'.$request->search.'%');
        })->when($request->category_id,function ($q) use ($request){
            return $q->where('category_id',$request->category_id);
        })->with('category')->paginate(5);
    }


    //function upload image
    public static function uploadImage($request):void
    {

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products_images/' . $request->image->hashName()));


        }

    //function delete image
    public static function deleteImage($product):void
    {

                 $path=$product->image_path;
                    $path=  substr($path, strpos($path, "uploads/products_images/"));
                File::delete($path);



    }

    //function store
    public static function storeProduct($request):void
    {

        $request_data=$request->except(['image']);

        if($request->image){
            self::uploadImage($request);
            $request_data['image']=$request->image->hashName();
        }
        Product::create($request_data);


    }
}

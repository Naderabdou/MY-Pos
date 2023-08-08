<?php
namespace App\Traits;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

trait UsersTrait
{
    //function search
    public function scopeWhenSearch($query,$search)

    {
        return $query->where(function ($w) use ($search){
           $w->when($search,function ($q) use ($search){
                return $q->where('first_name','like','%'.$search.'%')
                    ->orWhere('last_name','like','%'.$search.'%')
                    ->orWhere('email','like','%'.$search.'%');
            });
        })->latest()->paginate(5);


    }
    public static function uploadImage($request):void
    {
        if($request->image){
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_images/' . $request->image->hashName()));
            ;

        }
    }
    public static function deleteImage($user):void
    {

            if($user->image != 'default.png'){
                $path=$user->image;
                $path=  substr($path, strpos($path, "uploads/users_images/"));
                File::delete($path);
                    }
    }
    //function store
    public static function crud($user,$request):void
    {

        $request_data=$request->except(['password','password_confirmation','permissions','image']);

        $user->first_name=$request_data['first_name'];
        $user->last_name=$request_data['last_name'];
        $user->email=$request_data['email'];
        if ($request->password){
            $user->password=$request->password;
        }
        if($request->permissions){
            $user->syncPermissions($request->permissions);
        }
        if($request->image){
            self::deleteImage($user);
            self::uploadImage($request);
            $user->image=$request->image->hashName();

        }


        $user->save();
    }

}

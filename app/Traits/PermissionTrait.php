<?php
namespace App\Traits;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

trait PermissionTrait
{
    //function search
  public function permission($model)

  {
      ;

        $this->middleware('permission:'.$this->model.'_read')->only(['index']);
         $this->middleware('permission:'.$this->model.'_create')->only(['create','store']);
            $this->middleware('permission:'.$this->model.'_update')->only(['edit','update']);
            $this->middleware('permission:'.$this->model.'_delete')->only(['destroy']);


  }



}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Traits\PermissionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use PermissionTrait;
    public function __construct()
    {
        $this->model = 'user';
        $this->permission($this->model);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      //  $users=User::('admin')->whenSearch($request->search);
        $users=User::role('admin')->whenSearch($request->search);
        return view('dashboard.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Permissions=Permission::all();
        return view('dashboard.users.create',compact('Permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {

        $user=new User();
        $user->crud($user,$request);
        $user->assignRole('admin');
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.users.index');
    }


    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)

    {
        $Permissions=Permission::all();
        $user=User::findorFail($id);

        return view('dashboard.users.edit',compact('user','Permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->crud($user,$request);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.users.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //delete image
        $user->deleteImage($user);
        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');
    }
}

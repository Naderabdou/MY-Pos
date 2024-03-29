<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
       $roles= Role::all();
       $permissions= Permission::all();
        return view('dashboard.permissions.index',compact('roles','permissions'));
    }

}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\Client;
use App\Traits\PermissionTrait;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    use PermissionTrait;
    public function __construct()
    {
        $this->model = 'client';
        $this->permission($this->model);
    }
    public function index(Request $request)
    {
        $clients=Client::when($request->search,function($q) use($request){
            return $q->where('name','like','%'.$request->search.'%')
                ->orWhere('email','like','%'.$request->search.'%')
                ->orWhere('address','like','%'.$request->search.'%')
                ->orWhere('phone','like','%'.$request->search.'%');
        })->latest()->paginate(5);
        return view('dashboard.clients.index',compact('clients'));
    }

    public function create()
    {
        return view('dashboard.clients.create');
    }
    public function store(ClientStoreRequest $request)
    {

        $data=$request->validated();
        $data['phone']=array_filter($request->phone);
        Client::create($data);
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.clients.index');
    }

    public function edit(Client $client)
    {
        return view('dashboard.clients.edit',compact('client'));
    }
    public function update(ClientUpdateRequest $request,Client $client)
    {
        $data=$request->validated();
        $data['phone']=array_filter($request->phone);
        $client->update($data);
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.clients.index');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.clients.index');
    }
}

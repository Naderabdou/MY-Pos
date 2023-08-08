<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Traits\PermissionTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use PermissionTrait;
    public function __construct()
    {
        $this->model = 'category';
        $this->permission($this->model);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //search with pagination
        $categories=Category::when($request->search,function($q) use($request){
            return $q->whereTranslationLike('name','%'.$request->search.'%');
        }

        )->latest()->paginate(5);



         return view('dashboard.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(CategoryStoreRequest $request)
    {



        $data=$request->validated();


        Category::create($data);
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.categories.index');
    }

    public function edit(Category $category)
    {
        return view('dashboard.categories.edit',compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $data=$request->validated();
        $category->update($data);
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.categories.index');
    }
}

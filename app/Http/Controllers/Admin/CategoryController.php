<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role != 'admin')abort(403);

        $categories=Category::orderBy('id', 'desc')->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role != 'admin')abort(403);

        return view('admin.categories.editcreate');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        if(Auth::user()->role != 'admin')abort(403);

        $request->validated();
        $data = $request->all();
        $category = new Category;
        $category->fill($data);
        $category->save();
        return redirect()->route('admin.categories.show', $category);

    }

    /**
     * Display the specified resource.
     *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        if(Auth::user()->role != 'admin')abort(403);

        $categories=Category::all();
        $projects=Project::all()->where('category_id', $category->id);
        return view('admin.categories.show', compact('category','categories','projects'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if(Auth::user()->role != 'admin')abort(403);

        return view('admin.categories.editcreate', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if(Auth::user()->role != 'admin')abort(403);

        $request->validated();
        $data=$request->all();
        $category->fill($data);
        $category->save();
        return redirect()->route('admin.categories.show', $category);
    }

    /**
     * Remove the specified resource from storage.
     *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category)
    {
        if(Auth::user()->role != 'admin')abort(403);

        $action=$request->input('delete-action');

        if($action==='delete'){

            foreach($category->projects as $project){
                $project->delete();
            }
        } else{
            foreach($category->projects as $project){
                $project->category_id=$action;
                $project->save();
            }
            
        }


        $category->delete();
        return redirect()->route('admin.projects.index');
    }
}

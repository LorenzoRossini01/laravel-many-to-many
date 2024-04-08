<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects=Project::orderBy('id', 'desc');

        if(Auth::user()->role!='admin'){
            $projects->where('user_id',Auth::id());
        }

        $projects=$projects->paginate(15);

        return view('admin.projects.index', compact('projects'));

    }

    /**
     * Show the form for creating a new resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return view('admin.projects.editcreate', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $project = new Project;
        $project->fill($data);
        $project->user_id=Auth::id();
        $project->slug=Str::slug($project->title);
        $project->save();
        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Display the specified resource.
     *
    //  * @param  \App\Models\Project  $project
    //  * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        // controllo utente
        $autenticated_user_id=Auth::id();

        
        if(Auth::user()->role!='admin' && $autenticated_user_id != $project->user_id) abort(403);

        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
    //  * @param  \App\Models\Project  $project
    //  * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        // controllo utente
        $autenticated_user_id=Auth::id();
        if($autenticated_user_id != $project->user_id) abort(403);

        $categories=Category::all();
        return view('admin.projects.editcreate', compact('project','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        // controllo utente
        $autenticated_user_id=Auth::id();
        if($autenticated_user_id != $project->user_id) abort(403);


        $request->validated();
        $data=$request->all();
        $project->fill($data);
        $project->user_id=Auth::id();
        $project->slug=Str::slug($project->title);
        $project->save();
        return redirect()->route('admin.projects.show', $project);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        // controllo utente
        $autenticated_user_id=Auth::id();
        if($autenticated_user_id != $project->user_id) abort(403);

        $project->delete();
        return redirect()->route('admin.projects.index');

    }
}

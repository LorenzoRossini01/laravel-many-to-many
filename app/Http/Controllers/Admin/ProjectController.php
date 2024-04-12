<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Mail\EditProjectMail;
use App\Mail\NewProjectMail;
use App\Models\Category;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;


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
        $tags = Tag::all();

        return view('admin.projects.editcreate', compact('categories','tags'));
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
        // dd($data);
        $project = new Project;
        $project->fill($data);
        if(Arr::exists($data,'imageUrl')){
            $img_path=Storage::put('uploads\projects', $data['imageUrl']);
            $project->imageUrl=$img_path;
        }
        $project->user_id=Auth::id();
        $project->slug=Str::slug($project->title);
        $project->save();

        // dd($data['tag']);

        if(Arr::exists($data, 'tag')){
        $project->tags()->attach($data['tag']);};


        Mail::to('utente@mail.it')->send(new NewProjectMail($project,Auth::user()) );

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
        $tags=Tag::all();
        $project_tags_id=$project->tags->pluck('id')->toArray();
        return view('admin.projects.editcreate', compact('project','categories', 'tags','project_tags_id'));
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

        if(Arr::exists($data,'imageUrl')){
            if(!empty($project->imageUrl)){
                Storage::delete($project->imageUrl);
            }
            $img_path=Storage::put('uploads\projects', $data['imageUrl']);
            $project->imageUrl=$img_path;
        }

        $project->save();


        
        if(Arr::exists($data, "tag"))
        $project->tags()->sync($data["tag"]);
        else
        $project->tags()->detach();
        
        Mail::to('utente@mail.it')->send(new EditProjectMail($project,Auth::user()) );


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

        $project->tags()->detach();
        $project->delete();

        if(!empty($project->imageUrl)){
            Storage::delete($project->imageUrl);
        }

        return redirect()->route('admin.projects.index');

    }
    public function destroyImg(Project $project)
    {
        Storage::delete($project->imageUrl);
        $project->imageUrl=null;
        $project->save();
        return redirect()->back();

    }
}

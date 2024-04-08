@extends('layouts.app')

@section('content')
  <div class="container">
    <h2 class="fs-4 text-secondary my-4">{{isset($project)?'Modify project':'Add new project'}}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{isset($project)? route('admin.projects.update', $project) : route('admin.projects.store')}}" method="post">
        @csrf

        @if(isset($project))
            @method('patch')
        @endif

        <div class="row g-2">
            <div class="col-12 col-lg-6">
                <div class="card p-2 mb-2">
                    <label for="title" class="form-label">project title</label>
                    <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror"  value="{{isset($project)? $project->title:old('title')}}">
                    
                    @error("title")
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="card p-2">
                    <label for="imageUrl" class="form-label">project image url</label>
                    <input type="url" id="imageUrl" name="imageUrl" class="form-control @error('imageUrl') is-invalid @enderror" value="{{isset($project)? $project->imageUrl :old('imageUrl')}}">
                
                    @error("imageUrl")
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            
            <div class="col-12 col-lg-6">
                <div class="card p-2">
                    <label for="description" class="form-label">project description</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{isset($project)? $project->description :old('description')}}</textarea>
                    
                    @error("description")
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card p-2">
                    <label for="link" class="form-label">project GitHub link</label>
                    <input type="url" id="link" name="link" class="form-control @error('link') is-invalid @enderror" value="{{isset($project)? $project->link :old('link')}}">
                    
                    @error("link")
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card p-2">
                    <div class="row g-2">
                        <div class="col-10">
                            <label for="category_id" class="form-label ">Category</label>
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="" class="d-none">Seleziona una categoria</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{$category->id ==old('category_id',$project->category_id??'')?'selected':''}}>{{$category->label}}</option>
                                @endforeach
                            </select>
                            @error("category_id")
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="col-2 align-self-end">
                            <a href="{{route('admin.categories.create')}}" class="btn btn-secondary w-100">+</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary w-100 mt-2">Save project</button>
            </div>
        </div>
    </form>
  </div>
@endsection

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


    <form enctype="multipart/form-data" action="{{isset($project)? route('admin.projects.update', $project) : route('admin.projects.store')}}" method="post">
        @csrf

        @if(isset($project))
            @method('patch')
        @endif

        <div class="row g-2">
            {{-- input titolo descrizione --}}
            <div class="col-12 col-lg-6">
                <div class="card p-2 mb-2">
                    <label for="title" class="form-label">project title</label>
                    <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror"  value="{{isset($project)? $project->title:old('title')}}">
                    
                    @error("title")
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="card p-2">
                    <label for="description" class="form-label">project description</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{isset($project)? $project->description :old('description')}}</textarea>
                    
                    @error("description")
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>

            {{-- input file img  --}}
            <div class="col-12 col-lg-6">
                <div class="card p-2 h-100">
                    <label for="imageUrl" class="form-label">Immagine</label>
                    <input type="file" name="imageUrl" id="imageUrl" class="form-control">
                    @if(!empty($project->imageUrl))
                    <div class="preview-img ">
                        <img class="img-fluid w-100 mt-2 rounded" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSm0CSD7DWa8fEcafPXwwf64NnNDd0JX9xHIHfRZ4IXIQ&s" alt="">
                    </div>
                    @endif
                </div>
            </div>
            
            {{-- input link GitHub  --}}
            <div class="col-12 col-lg-6">
                <div class="card p-2 h-100">
                    <label for="link" class="form-label">project GitHub link</label>
                    <input type="url" id="link" name="link" class="form-control @error('link') is-invalid @enderror" value="{{isset($project)? $project->link :old('link')}}">
                    
                    @error("link")
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>

            {{-- input categorie  --}}
            <div class="col-12 col-lg-6">
                <div class="card p-2">
                    <div class="row g-2">
                        <label for="category_id" class="form-label ">Category</label>
                        <div class="col-10 ">
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
                        <div class="col-2 ">
                            <a href="{{route('admin.categories.create')}}" class="btn btn-secondary w-100">+</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- input tecnologie  --}}
            <div class="col-12 ">
                <div class="card p-2 h-100">
                    <label for="">Tecnologie usate</label>
                    <div class="d-flex flex-row justify-content-between flex-wrap">
                        @foreach($tags as $tag)
                        <div class="col-lg-4 col-6 form-check @error('tags') is-invalid @enderror">
                            <input type="checkbox" id="tag-{{$tag->id}}"  value="{{ $tag->id }}" name="tag[]" 
                            {{in_array($tag->id, old('tags',$project_tags_id??[]))?'checked':'' }}>
                            <label for="tag-{{$tag->id}}" class="form-check-label">{{$tag->label}}</label>
                        </div>
                        @endforeach
                        @error("tags")
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100 mt-2">Save project</button>
            </div>
        </div>
    </form>
  </div>
@endsection

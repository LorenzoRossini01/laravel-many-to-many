@extends('layouts.app')

@section('content')
  <div class="container project-show">
    <h2 class="fs-4 text-secondary my-4">Project Details</h2>

    <div class="card">
        <div class="card-header">
            <h2>{{$project->title}}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <img src="{{asset('storage/'. $project->imageUrl)}}" alt="" class="image-fluid">
                </div>
                <div class="col-6">
                    <p>{{$project->description}}</p>                    
                    <a href="{{$project->link}}">{{$project->link}}</a>
                    <div class="my-2">
                      <strong>Categoria:</strong>
                      <a href="{{route('admin.categories.show', $project->category)}}">{!!$project->category->getBadge()!!}</a>
                    </div>
                    <div class="my-2">
                      <strong>Tecnologie:</strong>
                      <p>{{$project->getHashtag()}}</p>
                    </div>
                    <div class="my-2">
                      <strong>Autore: </strong>
                      {{$project->user->name}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-2">
        <div class="col-6">
            <a href="{{route('admin.projects.edit', $project)}}" class="btn btn-warning w-100">Edit project details</a>
        </div>
        <div class="col-6">
            <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $project->id }}">Delete project</button>
        </div>
    </div>


  </div>
  <div class="modal fade" id="delete-modal-{{ $project->id }}" tabindex="-1" aria-labelledby="delete-modal-{{ $project->id }}-label"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="delete-modal-{{ $project->id }}-label">Conferma eliminazione</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-start">
          Sei sicuro di voler eliminare definitivamente il progetto: {{ $project->name }}?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

          <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="">
            @method('DELETE')
            @csrf

            <button type="submit" class="btn btn-danger">Elimina</button>
          </form>
        </div>
      </div>
    </div>
@endsection



@extends('layouts.app')

@section('content')
  <div class="container project-index">
    <h2 class="fs-4 text-secondary my-4">Project List</h2>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titolo</th>
                <th>Autore</th>
                <th>Descrizione</th>
                <th>Categoria</th>
                <th>Tags</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
            <tr>
                <td>{{$project->id}}</td>
                <td>{{$project->title}}</td>
                <td>{{$project->user->name}}</td>
                <td>{{$project->getAbstract()}}</td>
                <td>
                    @if(@isset($project->category))
                    <a href="{{route('admin.categories.show', $project->category)}}">{!!$project->category?->getBadge()!!}</a>
                    @endif
                </td>
                <td>{{$project->getHashtag()}}</td>
                <td><a href="{{route('admin.projects.show', $project)}}">più dettagli...</a></td>
            </tr>
            @empty
            <tr>
                <td colspan="100%">Non ci sono progetti</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{$projects->links('pagination::bootstrap-5')}}
  </div>
@endsection

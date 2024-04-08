@extends('layouts.app')

@section('content')
  <div class="container category-index">
    <h2 class="fs-4 text-secondary my-4">category List</h2>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Etichetta</th>
                <th>Codice HEX</th>
                <th>Categoria</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->label}}</td>
                <td>{{$category->color}}</td>
                <td>{!!$category->getBadge()!!}</td>
                <td><a href="{{route('admin.categories.show', $category)}}">più dettagli...</a></td>
            </tr>
            @empty
            <tr>
                <td colspan="100%">Non ci sono categorie</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{$categories->links('pagination::bootstrap-5')}}
  </div>
@endsection

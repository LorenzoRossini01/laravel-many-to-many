@extends('layouts.app')

@section('content')
  <div class="container">
    <h2 class="fs-4 text-secondary my-4">{{isset($category)?'Modify category':'Add new category'}}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{isset($category)? route('admin.categories.update', $category) : route('admin.categories.store')}}" method="post">
        @csrf

        @if(isset($category))
            @method('patch')
        @endif

        <div class="row g-2">
            <div class="col-12 col-lg-6">
                <div class="card p-2 h-100">
                    <label for="label" class="form-label">category name</label>
                    <input type="text" id="label" name="label" class="form-control @error('label') is-invalid @enderror"  value="{{isset($category)? $category->label:old('label')}}">
                    
                    @error("label")
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="col-12 col-lg-6">

            <div class="card p-2 h-100">
                <label for="color" class="form-label">category badge color</label>
                <input type="color" id="color" name="color" class="form-control @error('color') is-invalid @enderror" value="{{isset($category)? $category->color :old('color')}}">
            
                @error("color")
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            </div>

            
            <div class="col-12">
                <button class="btn btn-primary w-100 ">Save category</button>
            </div>
        </div>
    </form>
  </div>
@endsection

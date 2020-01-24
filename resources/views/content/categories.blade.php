@extends('master')
@section('content')
    <h1 class="page-header">
        <br>categories

    </h1>
    <br>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{url('categories')}}">
        @csrf
        <div class="form-group">
            <label for="name">category</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="plz enter the category">
        </div>

        <button type="submit" class="btn btn-primary btn-block">add category</button>
    </form>


@endsection


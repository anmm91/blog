@extends('master')
@section('content')
    <h1 class="page-header">
        <br>register

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
    @if($stop_register == 1)
        <h4> sorry  can't make register now</h4>
        @else
        <form method="post" action="/register" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">name</label>
                <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name">
            </div>
            <div class="form-group">
                <label for="email">email</label>
                <input type="text" id="email" name="email"  value="{{old('email')}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">password</label>
                <input type="password" name="password"   class="form-control" id="password">
            </div>
            <div class="form-group">
                <label for="image">image</label>
                <input type="file" name="image"   class="form-control" id="image">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
        </form>
    @endif


@endsection



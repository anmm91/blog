@extends('master')
@section('content')
    <h1 class="page-header">
        <br>login

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
    <form method="post" action="/login" enctype="">
        @csrf


        <div class="form-group">
            <label for="email">email</label>
            <input type="text" id="email" name="email"  value="{{old('email')}}" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">password</label>
            <input type="password" name="password"   class="form-control" id="password">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
    </form>



@endsection



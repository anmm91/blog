
@extends('master')
@section('content')
    <h1 class="page-header">
        <br>category

    </h1>
    <br>

    @if(!empty($posts))

        @foreach($posts as  $post)


    <!-- First Blog Post -->
    <h2>
        <a href="{{url('post/'.$post->id)}}">{{$post->title}}</a>
    </h2>

    <p><span class="glyphicon glyphicon-time"></span> Posted on {{$post->created_at->toDayDateTimeString()}}</p>
    <hr>
    <img class="img-responsive" src="{{asset('/storage/images/'.$post->url)}}" width="400" height="400" alt="image">
    <hr>
    <p>{{$post->body}}</p>
    <a class="btn btn-primary" href="{{url('post/'.$post->id)}}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

    <hr>

    @endforeach
    @else
        <div class="alert alert-info">
            no posts
        </div>
    @endif
@endsection


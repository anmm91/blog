@extends('master')
@section('content')
    <h1 class="page-header">
        <br>post

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
    @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
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
    <div class="row">
        @if(!empty($post))
            @foreach($post->comments  as $comment)
                <li>{{$comment->body}}</li>
            @endforeach
        @else
            <div class="alert alert-info">
                no comment on this post
            </div>
        @endif
    </div>
    @if($stop_comment == 1)
        <h4>sorry the comments not allowed</h4>
        @else
        <form method="post" action="{{url('/post/'.$post->id.'/store')}}">
            @csrf
            <div class="form-group">
                <label for="body"></label>
                <textarea id="body" name="body"  value="{{old('body')}}" class="form-control" placeholder="Enter the comment"></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">add comment</button>
        </form>
    @endif

@endsection

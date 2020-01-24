@extends('master')
@section('content')
    <h1 class="page-header">
        <br>posts

    </h1>
    <br>
    @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(count($posts))
        {{$posts->links()}}
    @foreach($posts as $post)


    <!-- First Blog Post -->
        <h2>
            <a href="{{url('post/'.$post->id)}}">{{$post->title}}</a>
        </h2>
         {{$post->user->name}}
         <img src="{{asset('/storage/imageuser/'.$post->user->image)}}" width="80" height="80"  class="rounded float-left img-responsive img-circle">
    <p><span class="glyphicon glyphicon-time"></span> <b>Posted on</b> {{$post->created_at->toDayDateTimeString()}}</p>
        <hr>
        <b>category:</b><a href="{{url('category/'.$post->category->id)}}">{{$post->category->name}}</a>
        <img class="img-responsive" src="{{asset('/storage/images/'.$post->url)}}" width="400" height="400" alt="image">

        <hr>
        <p>{{$post->body}}</p>
        <a class="btn btn-primary" href="{{url('post/'.$post->id)}}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
        @php
            $like='';
                $like_count=0;
                $dislike_count=0;
                $like_status="btn btn-secondary";
                $dislike_status="btn btn-secondary";

        @endphp
        @foreach($post->likes as $like)


            @php

                if($like->like == 1){
                $like_count++;
                }if($like->like == 0){
                    $dislike_count++;
                }
                if(auth()->check()){
                        if($like->like== 1  && $like->user_id==auth()->user()->id){
                            $like_status="btn btn-success";
                        }
                        if($like->like== 0  && $like->user_id==auth()->user()->id){
                            $dislike_status="btn btn-danger";
                        }

                }

            @endphp

        @endforeach

            <button data-like="{{$like_status}}"   data-postid="{{$post->id}}_l" class="{{$like_status}} like">
                Like <span class="glyphicon glyphicon-thumbs-up"></span>
                <b><span class="like-count">{{$like_count}}</span></b>
            </button>
            <button data-dislike="{{$dislike_status}}"  data-postid="{{$post->id}}_d" class="{{$dislike_status}} dislike">
                Dislike <span class="glyphicon glyphicon-thumbs-down"></span>
                <b><span class="dislike-count">{{$dislike_count}}</span></b>
            </button>
        <hr>
    @endforeach
    @else
        <div class="alert alert-info">
            no data to display
        </div>

    @endif
    @if(auth()->check())
    @if(auth()->user()->hasRole('admin'))
        <form method="post" action="/post/store" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="category_id">category</label>
                <select name="category_id" class="form-control">
                    <option value="">choose category ....</option>
                    @if(!empty($categories))
                        @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach

                        @else
                       <div>no category</div>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="title">title</label>
                <input type="text" name="title" value="{{old('title')}}" class="form-control" id="title" placeholder="Enter the post title">
            </div>
            <div class="form-group">
                <label for="body">body</label>
                <textarea id="body" name="body"  value="{{old('body')}}" class="form-control" placeholder="Enter the body of the post"></textarea>
            </div>
            <div class="form-group">
                <label for="file">image</label>
                <input type="file" name="url"  value="{{old('url')}}" class="form-control" id="file">
            </div>
            <button type="submit" class="btn btn-primary btn-block">add post</button>
        </form>
    @endif
    @endif
@endsection

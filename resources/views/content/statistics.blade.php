@extends('master')
@section('content')
    <div class="col-md-9">

        <h1 class="page-header">
            <br>statistics

        </h1>
        <br>

        <table class="table table-hover">
            <tr>
                <td>users</td>
                <td>{{$statistics['users']}}</td>
            </tr>
            <tr>
                <td>posts</td>
                <td>{{$statistics['posts']}}</td>
            </tr>
            <tr>
                <td>comments</td>
                <td>{{$statistics['comments']}}</td>
            </tr>
            <tr>
                <td>most active user</td>
                <td>{{$statistics['active_user']}} <b>like :</b>{{$statistics['active_user_likes']}} <b>, comment:</b>{{$statistics['active_user_comments']}}</td>
            </tr>

        </table>
@endsection

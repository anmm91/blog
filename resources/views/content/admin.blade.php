@extends('master')
@section('content')
    <h1 class="page-header">
        <br>admin

    </h1>
    <br>
<h4>control panel</h4>
<h6> list of user</h6>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div>
    <table class="table table-hover">
        <tr>
            <th>#</th>
            <th>name</th>
            <th>email</th>
            <th>user</th>
            <th>editor</th>
            <th>admin</th>
        </tr>
        @if(!empty($users))
        @foreach($users as $user)
        <form method="post" action="add-role">
            @csrf
        <input type="hidden" name="email" value="{{$user->email}}">
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>
                <input type="checkbox" onchange="this.form.submit()" name="user" {{$user->hasRole('user') ?  'checked'  :   ''}}>
            </td>
            <td>
                <input type="checkbox" onchange="this.form.submit()" name="editor" {{$user->hasRole('editor') ? 'checked'  :   ''}}>
            </td>
            <td>
                <input type="checkbox" onchange="this.form.submit()" name="admin" {{$user->hasRole('admin') ?  'checked'  :    '' }}>
            </td>
        </tr>
        </form>
        @endforeach
        @endif
    </table>

    <form method="post" action="setting">
        @csrf
        <b>stop comment</b>:<input type="checkbox"  onchange="this.form.submit()" name="comment" {{$stop_comment ==1 ? 'checked' : ''}}><br>
        <b>stop register</b>:<input type="checkbox"name="stop-register" onchange="this.form.submit()"{{$stop_register ==1 ? 'checked' : ''}}>
    </form>
</div>
@endsection


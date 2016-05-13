@extends('layouts.admin')

    @section('content')
        <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="/user-profile/change">
            {!! csrf_field() !!}
            <h3 align="center" style="color: red">{{ session('status') }}</h3>
            <div class="list-group" id = "user-profile">
                <button type="button" class="list-group-item">ID: {{Auth::user()->id}}</button>
                <button type="button" class="list-group-item">Name: {{Auth::user()->name}}</button>
                <button type="button" class="list-group-item">Email: {{Auth::user()->email}}</button>
                <button type="button" class="list-group-item">Role: {{Auth::user()->role}}</button>
                <button type="button" class="list-group-item">Avatar:
                    @if(isset(Auth::user()->avatar))
                        <img class="media-object" src="/{{Auth::user()->avatar}}" style="width:120px; height: 120px">
                    @else
                        <img class="media-object" src="/uploads/user_image/no_avatar.jpg" style="width:120px; height: 120px">
                    @endif
                    <div>
                        <input type="file" id ="photo"  name="avatar" accept="image/*,image/jpeg,gif,png"><br>
                        <input type="submit" class="btn btn-primary" value="Upload">

                    </div>

                </button>
                <button type="button" class="list-group-item">Created: {{Auth::user()->created_at}}</button>
            </div>
        </form>
    @endsection
@extends('layouts.admin')

@section('content')
<div class="container" style="margin-top: -10px">
    <div class="row">
        <div class="col-xs-16" align="center">
            <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="user-profile/change">
                {!! csrf_field() !!}
                <h2 align="center">Profile</h2>
                <h3 align="center" style="color: red">{{ session('status') }}</h3>
                <div class="list-group" id = "user-profile" style="width: 600px">
                    <button type="button" class="list-group-item"><b>ID</b>: {{Auth::user()->id}}</button>
                    <button type="button" class="list-group-item"><b>Card-ID</b>: {{Auth::user()->card_id}}</button>
                    <button type="button" class="list-group-item"><b>FirstName:</b> {{Auth::user()->first_name}}</button>
                    <button type="button" class="list-group-item"><b>SecondName:</b> {{Auth::user()->second_name}}</button>
                    <button type="button" class="list-group-item"><b>DepartmentName:</b> {{Auth::user()->department_name}}</button>
                    <button type="button" class="list-group-item"><b>ValidTo:</b> {{Auth::user()->valid_to}}</button>
                    <button type="button" class="list-group-item"><b>Role:</b> {{Auth::user()->role}}</button>
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
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
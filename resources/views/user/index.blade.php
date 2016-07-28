@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: -50px">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-8">
            <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="user-profile/change">
                {!! csrf_field() !!}
                <h3 align="center">Profile</h3>
                <h3 align="center" style="color: red">{{ session('status') }}</h3>
                <div class="list-group" id = "user-profile" style="width: 600px">
                <button type="button" class="list-group-item"><b>ID</b>: {{Auth::user()->id}}</button>
                    <button type="button" class="list-group-item"><b>Card-ID</b>: {{Auth::user()->card_id}}</button>
                    <button type="button" class="list-group-item"><b>FirstName:</b> {{Auth::user()->first_name}}</button>
                    <button type="button" class="list-group-item"><b>SecondName:</b> {{Auth::user()->second_name}}</button>
                    <button type="button" class="list-group-item"><b>DepartmentName:</b> {{Auth::user()->department_name}}</button>
                    <button type="button" class="list-group-item"><b>ValidTo:</b> {{Auth::user()->valid_to}}</button>
                    <button type="button" class="list-group-item"><b>Role:</b> {{Auth::user()->role}}</button>
                    <button type="button" class="list-group-item"><b>Status:</b> {{Auth::user()->status}}</button>
                    <button type="button" class="list-group-item">Avatar:
                        @if(isset(Auth::user()->avatar))
                            <img class="media-object" src="{{Auth::user()->avatar}}" style="width:120px; height: 120px">
                        @else
                            <img class="media-object" src="uploads/user_image/no_avatar.jpg" style="width:120px; height: 120px">
                        @endif
                        <div>
                            <input type="file" id ="photo"  name="avatar" accept="image/*,image/jpeg,gif,png"><br>
                            <input type="submit" class="btn btn-primary" value="Upload">
                        </div>
                    </button>
                </div>
            </form>
        </div>
        @if($projects != null)
        <div class="col-xs-6 col-md-4" style="margin-top: 5px">
            <h3 align="center">Projects</h3>
            <div class="list-group-item" style="margin-top: 13px; word-wrap: break-word;">
                @foreach ($projects as $project)
                <ul>
                    <li>
                        <b>-ID:</b> {{ $project->project_id }}
                    </li>
                    <ul>
                        <li>
                            <b>Title:</b> {{ $project->title }}
                        </li>
                        <li>
                            <b>Description:</b> {{ $project->description }}
                        </li>
                        <li>
                            <b>Software Requirements:</b> {{ $project->software_requirements }}
                        </li>
                        <li>
                            <b>Recomended Literature:</b> {{ $project->recomended_literature }}
                        </li>
                        <li>
                            <meta name="csrf-token" content="{{ csrf_token() }}" />
                            <b>Status:</b> <span id="div-status-{{$project->project_id}}">{{ $project->status }}</span>
                            <select id="status-{{$project->project_id}}" onchange="changeStatus({{$project->project_id}}); return false">
                                <option value="0" selected disabled></option>
                                <option value="check">check</option>
                                <option value="todo">todo</option>
                                <option value="done">done</option>
                                <option value="problem">problem</option>
                            </select>
                        </li>
                        <hr>
                    </ul>
                </ul>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>


@endsection
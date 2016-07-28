@extends('layouts.admin')

@section('content')

<table class="table table-bordered table-hover" style="margin: 50px; width: 800px">
    <thead>
        <tr>
            <th>ID</th>
            <th>FirstName</th>
            <th>SecondName</th>
            <th>DepartmentName</th>
            <th>Card-ID</th>
            <th>ValidTo</th>
            <th>Role</th>
            <th>Avatar</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td><p>{{$user->id}}</p></td>
            <td><p>@if($user->first_name != null) {{$user->first_name}} @else - @endif</p></td>
            <td><p>@if($user->second_name != null) {{$user->second_name}} @else - @endif</p></td>
            <td><p>@if($user->department_name != null) {{$user->department_name}} @else - @endif</p></td>
            <td><p>{{$user->card_id}}</p></td>
            <td><p>@if($user->valid_to != null) {{$user->valid_to}} @else - @endif</p></td>
            <td><p>{{$user->role}}</p></td>
            <td>
                @if($user->avatar ==NULL)
                <p>No Avatar!</p>
                @else
                <img src="/{{$user->avatar}}" width="120px" height="120px">
                @endif
            </td>
            <meta name="admin-csrf-token" content="{{ csrf_token() }}"/>
            <td><p><span id="admin-div-status-{{$user->id}}" @if($user->status == 'deny') style="color:red" @endif>{{$user->status}}<span>
                </p>
                <select id="admin-status-{{$user->id}}"
                        onchange="changeUserStatus({{$user->id}}); return false" style="color:black">
                    <option value="0" selected disabled></option>
                    <option value="allow">allow</option>
                    <option value="deny">deny</option>
                </select>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
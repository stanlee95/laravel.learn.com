@extends('layouts.admin')

    @section('content')
        <h1>Welcome to admin-panel, {{Auth::user()->name}}</h1>
    @endsection
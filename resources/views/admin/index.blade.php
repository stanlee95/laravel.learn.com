@extends('layouts.admin')

    @section('content')
        <h1>Welcome to admin-panel, {{Auth::user()->card_id}}</h1>
    @endsection